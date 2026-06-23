<?php

use PHPUnit\Framework\TestCase;

class CsrfTest extends TestCase
{
    /** Bootstrap must generate a CSRF token using random_bytes */
    public function testBootstrapGeneratesCsrfToken(): void
    {
        $source = file_get_contents(ROOT_PATH . 'core/bootstrap.php');
        $this->assertStringContainsString('csrf_token', $source,
            'No CSRF token generation found in bootstrap.php');
        $this->assertStringContainsString('random_bytes', $source,
            'CSRF token not generated with random_bytes() in bootstrap.php');
    }

    /** Bootstrap must validate the CSRF token on POST requests */
    public function testBootstrapValidatesCsrfToken(): void
    {
        $source = file_get_contents(ROOT_PATH . 'core/bootstrap.php');
        $this->assertStringContainsString('hash_equals', $source,
            'No timing-safe hash_equals() CSRF check in bootstrap.php');
    }

    /** Installer controller must be exempt from CSRF validation */
    public function testInstallerIsExemptFromCsrf(): void
    {
        $source = file_get_contents(ROOT_PATH . 'core/bootstrap.php');
        $this->assertStringContainsString('Installer', $source,
            'Installer CSRF exemption not found in bootstrap.php');
    }

    /** Every POST form in views must include a csrf_token hidden field (Installer exempt) */
    public function testViewFormsContainCsrfToken(): void
    {
        $missing = [];
        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(ROOT_PATH . 'application/views/')
        );
        foreach ($it as $file) {
            if ($file->getExtension() !== 'php') { continue; }
            // Installer is exempt from CSRF validation — skip its views
            if (str_contains($file->getPathname(), DIRECTORY_SEPARATOR . 'Installer' . DIRECTORY_SEPARATOR)) {
                continue;
            }
            $content = file_get_contents($file->getPathname());
            if (!preg_match('/<form[^>]+method=["\']?post["\']?/i', $content)) { continue; }
            if (!str_contains($content, 'csrf_token')) {
                $missing[] = str_replace(ROOT_PATH, '', $file->getPathname());
            }
        }
        $this->assertEmpty($missing,
            "POST forms missing csrf_token hidden field in:\n" . implode("\n", $missing));
    }

    /** Must use timing-safe comparison — not simple === */
    public function testTimingSafeComparisonUsed(): void
    {
        $source = file_get_contents(ROOT_PATH . 'core/bootstrap.php');
        $this->assertStringNotContainsString(
            "csrf_token'] ===",
            $source,
            'CSRF token compared with === instead of hash_equals()'
        );
    }
}
