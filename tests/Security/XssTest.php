<?php

use PHPUnit\Framework\TestCase;

class XssTest extends TestCase
{
    /** h() helper function must exist in functions.inc.php */
    public function testEscapeHelperExists(): void
    {
        require_once ROOT_PATH . 'application/config/functions.inc.php';
        $this->assertTrue(function_exists('h'),
            'h() helper not found in application/config/functions.inc.php');
    }

    /** h() must correctly escape XSS characters */
    public function testEscapeHelperWorks(): void
    {
        require_once ROOT_PATH . 'application/config/functions.inc.php';
        $this->assertSame('&lt;script&gt;alert(1)&lt;/script&gt;', h('<script>alert(1)</script>'));
        $this->assertSame('&quot;', h('"'));
        $this->assertSame('&#039;', h("'"));
        $this->assertSame('', h(''));
        $this->assertSame('safe text', h('safe text'));
    }

    /** No view file may echo a raw superglobal into HTML */
    public function testNoRawSuperglobalEchoInViews(): void
    {
        $violations = [];
        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(ROOT_PATH . 'application/views/')
        );
        $pattern = '/\becho\s+\$_(GET|POST|REQUEST)\b|<\?=\s*\$_(GET|POST|REQUEST)\b/i';

        foreach ($it as $file) {
            if (!in_array(strtolower($file->getExtension()), ['php'])) { continue; }
            $content = file_get_contents($file->getPathname());
            if (preg_match($pattern, $content)) {
                $violations[] = str_replace(ROOT_PATH, '', $file->getPathname());
            }
        }
        $this->assertEmpty($violations,
            "Raw superglobal echoed into HTML in:\n" . implode("\n", $violations));
    }

    /** No controller may echo a raw superglobal */
    public function testNoRawSuperglobalEchoInControllers(): void
    {
        $violations = [];
        $pattern = '/\becho\s+\$_(GET|POST|REQUEST)\b/i';

        foreach (glob(ROOT_PATH . 'application/controllers/*.php') as $file) {
            if (preg_match($pattern, file_get_contents($file))) {
                $violations[] = basename($file);
            }
        }
        $this->assertEmpty($violations,
            "Raw superglobal echoed in controllers:\n" . implode("\n", $violations));
    }

    /** The old XSS input block in index.php must stay commented out */
    public function testOldXssInputBlockStillDisabled(): void
    {
        $source = file_get_contents(ROOT_PATH . 'index.php');
        // Strip single-line comments then check the active code has no htmlentities on $_REQUEST
        $stripped = preg_replace('/\/\/[^\n]*/', '', $source);
        $this->assertStringNotContainsString(
            '$_REQUEST[$v] = htmlentities',
            $stripped,
            'Old input-sanitisation XSS block appears to be active in index.php — must stay commented out'
        );
    }
}
