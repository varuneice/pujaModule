<?php
/**
 * Phase 7 — Core Framework PHP 8.2 Compatibility Tests (RED phase)
 *
 * These tests verify that the core framework files are PHP 8.2 compatible:
 * 1. No mysql_* function calls (removed in PHP 7.0, definitely gone in PHP 8.x)
 * 2. IteratorAggregate::getIterator() has correct return type (\Traversable)
 * 3. Countable::count() has correct return type (int)
 * 4. No utf8_encode() / utf8_decode() calls (deprecated PHP 8.2, removed PHP 9.0)
 */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class CoreFrameworkTest extends TestCase
{
    // ---------------------------------------------------------------
    // mysql_* functions (removed PHP 7.0)
    // ---------------------------------------------------------------

    /** Object.class.php must not call mysql_query() */
    public function testNoMysqlQueryInObjectClass(): void
    {
        $file = ROOT_PATH . 'core/framework/Object.class.php';
        $source = file_get_contents($file);
        // Strip single-line comments to avoid false positives on commented code
        $stripped = preg_replace('/\/\/[^\n]*/', '', $source);
        $stripped = preg_replace('/\/\*.*?\*\//s', '', $stripped);
        $this->assertStringNotContainsString(
            'mysql_query(',
            $stripped,
            'Object.class.php calls mysql_query() which was removed in PHP 7.0'
        );
    }

    /** Object.class.php must not call mysql_fetch_assoc() */
    public function testNoMysqlFetchAssocInObjectClass(): void
    {
        $file = ROOT_PATH . 'core/framework/Object.class.php';
        $source = file_get_contents($file);
        $stripped = preg_replace('/\/\/[^\n]*/', '', $source);
        $stripped = preg_replace('/\/\*.*?\*\//s', '', $stripped);
        $this->assertStringNotContainsString(
            'mysql_fetch_assoc(',
            $stripped,
            'Object.class.php calls mysql_fetch_assoc() which was removed in PHP 7.0'
        );
    }

    /** No PHP file in core/ should use mysql_* functions */
    public function testNoCoreFilesUseMysqlFunctions(): void
    {
        $coreDir = ROOT_PATH . 'core/';
        $violations = [];
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($coreDir));
        foreach ($rii as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $src = file_get_contents($file->getPathname());
                $stripped = preg_replace('/\/\/[^\n]*/', '', $src);
                $stripped = preg_replace('/\/\*.*?\*\//s', '', $stripped);
                if (preg_match('/\bmysql_\w+\s*\(/', $stripped)) {
                    $violations[] = $file->getPathname();
                }
            }
        }
        $this->assertEmpty(
            $violations,
            'Core files still use mysql_* functions: ' . implode(', ', $violations)
        );
    }

    // ---------------------------------------------------------------
    // IteratorAggregate::getIterator() return type (PHP 8.0+ requirement)
    // ---------------------------------------------------------------

    /** BaseQuery::getIterator() must declare return type \Traversable */
    public function testBaseQueryGetIteratorHasReturnType(): void
    {
        $file = ROOT_PATH . 'core/framework/BaseQuery.php';
        $source = file_get_contents($file);
        $this->assertMatchesRegularExpression(
            '/function\s+getIterator\s*\(\s*\)\s*:\s*\\\\?Traversable/',
            $source,
            'BaseQuery::getIterator() must declare return type ": \Traversable" (required by PHP 8.0 IteratorAggregate interface)'
        );
    }

    // ---------------------------------------------------------------
    // Countable::count() return type (PHP 8.0+ requirement)
    // ---------------------------------------------------------------

    /** SelectQuery::count() must declare return type int */
    public function testSelectQueryCountHasIntReturnType(): void
    {
        $file = ROOT_PATH . 'core/framework/SelectQuery.php';
        $source = file_get_contents($file);
        $this->assertMatchesRegularExpression(
            '/function\s+count\s*\(\s*\)\s*:\s*int/',
            $source,
            'SelectQuery::count() must declare return type ": int" (required by PHP 8.0 Countable interface)'
        );
    }

    // ---------------------------------------------------------------
    // utf8_encode() / utf8_decode() (deprecated PHP 8.2, removed PHP 9.0)
    // ---------------------------------------------------------------

    /** uploader class.upload.php must not use utf8_encode() */
    public function testNoUtf8EncodeInUploader(): void
    {
        $file = ROOT_PATH . 'application/helpers/uploader/class.upload.php';
        if (!file_exists($file)) {
            $this->markTestSkipped('class.upload.php not found');
        }
        $source = file_get_contents($file);
        $stripped = preg_replace('/\/\/[^\n]*/', '', $source);
        $stripped = preg_replace('/\/\*.*?\*\//s', '', $stripped);
        $this->assertStringNotContainsString(
            'utf8_encode(',
            $stripped,
            'class.upload.php uses utf8_encode() which is deprecated in PHP 8.2 — replace with mb_convert_encoding()'
        );
    }

    /** uploader class.upload.php must not use utf8_decode() */
    public function testNoUtf8DecodeInUploader(): void
    {
        $file = ROOT_PATH . 'application/helpers/uploader/class.upload.php';
        if (!file_exists($file)) {
            $this->markTestSkipped('class.upload.php not found');
        }
        $source = file_get_contents($file);
        $stripped = preg_replace('/\/\/[^\n]*/', '', $source);
        $stripped = preg_replace('/\/\*.*?\*\//s', '', $stripped);
        $this->assertStringNotContainsString(
            'utf8_decode(',
            $stripped,
            'class.upload.php uses utf8_decode() which is deprecated in PHP 8.2 — replace with mb_convert_encoding()'
        );
    }
}
