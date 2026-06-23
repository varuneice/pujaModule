<?php

use PHPUnit\Framework\TestCase;

class Phase1Test extends TestCase
{
    /** Backup controllers must not exist */
    public function testBackupControllersDeleted(): void
    {
        $files = glob(ROOT_PATH . 'application/controllers/*', GLOB_NOSORT);
        $found = [];
        foreach ($files as $f) {
            $base = basename($f);
            if (preg_match('/backup|_bkp|_HIST|_July|_may/i', $base)) {
                $found[] = $base;
            }
        }
        $this->assertEmpty($found, "Backup controllers still present: " . implode(', ', $found));
    }

    /** Backup models must not exist */
    public function testBackupModelsDeleted(): void
    {
        $files = glob(ROOT_PATH . 'application/models/*', GLOB_NOSORT);
        $found = [];
        foreach ($files as $f) {
            $base = basename($f);
            if (preg_match('/backup|_bkp|_HIST|_July|_may/i', $base)) {
                $found[] = $base;
            }
        }
        $this->assertEmpty($found, "Backup models still present: " . implode(', ', $found));
    }

    /** Backup views must not exist */
    public function testBackupViewsDeleted(): void
    {
        $found = [];
        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(ROOT_PATH . 'application/views/')
        );
        foreach ($it as $file) {
            if ($file->isDir()) continue;
            $base = $file->getFilename();
            if (preg_match('/backup|_bkp|_HIST|_July|_may/i', $base)) {
                $found[] = str_replace(ROOT_PATH, '', $file->getPathname());
            }
        }
        $this->assertEmpty($found, "Backup views still present:\n" . implode("\n", $found));
    }

    /** Production password must not appear in any source file */
    public function testProductionPasswordNotInSource(): void
    {
        $configContent    = file_get_contents(ROOT_PATH . 'config.php');
        $constantsContent = file_get_contents(ROOT_PATH . 'application/config/constants.php');
        $this->assertStringNotContainsString('GhKiBW1zVyCL', $configContent,
            'Production password found in config.php');
        $this->assertStringNotContainsString('GhKiBW1zVyCL', $constantsContent,
            'Production password found in constants.php');
    }

    /** application/config/ must have an .htaccess denying all HTTP access */
    public function testConfigDirectoryHasHtaccess(): void
    {
        $path = ROOT_PATH . 'application/config/.htaccess';
        $this->assertFileExists($path, 'application/config/.htaccess does not exist');
        $content = file_get_contents($path);
        $this->assertMatchesRegularExpression('/deny\s+from\s+all/i', $content,
            'application/config/.htaccess does not contain "Deny from all"');
    }

    /** Root .htaccess must not contain the wildcard CORS header */
    public function testCorsWildcardRemovedFromHtaccess(): void
    {
        $content = file_get_contents(ROOT_PATH . '.htaccess');
        $this->assertStringNotContainsString(
            'Allow-Origin "*"',
            $content,
            'Wildcard CORS header still present in root .htaccess'
        );
    }

    /** Root .htaccess must block sensitive file types */
    public function testHtaccessBlocksSensitiveFiles(): void
    {
        $content = file_get_contents(ROOT_PATH . '.htaccess');
        $this->assertStringContainsString('FilesMatch', $content,
            'Root .htaccess is missing a FilesMatch block for sensitive files');
        $this->assertStringContainsString('sql', $content,
            'Root .htaccess FilesMatch block does not mention sql');
        $this->assertStringContainsString('Deny from all', $content,
            'Root .htaccess FilesMatch block missing "Deny from all"');
    }
}
