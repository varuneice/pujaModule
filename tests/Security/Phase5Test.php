<?php

use PHPUnit\Framework\TestCase;

class Phase5Test extends TestCase
{
    /** error_reporting(0) must not exist in config.php */
    public function testErrorReportingNotSuppressed(): void
    {
        $source = file_get_contents(ROOT_PATH . 'application/config/config.php');
        $this->assertStringNotContainsString(
            'error_reporting(0)',
            $source,
            'error_reporting(0) still present in application/config/config.php'
        );
    }

    /** display_errors On must not be hardcoded in index.php */
    public function testDisplayErrorsNotHardcoded(): void
    {
        $source = file_get_contents(ROOT_PATH . 'index.php');
        $this->assertStringNotContainsString(
            'ini_set("display_errors", "On")',
            $source,
            'display_errors hardcoded On in index.php'
        );
        $this->assertStringNotContainsString(
            "ini_set('display_errors', 'On')",
            $source,
            'display_errors hardcoded On in index.php'
        );
    }

    /** Util::incrementalHash must use random_int, not rand */
    public function testIncrementalHashUsesRandomInt(): void
    {
        $source = file_get_contents(ROOT_PATH . 'application/config/functions.inc.php');
        // Check incrementalHash function body
        preg_match('/function incrementalHash.*?(?=public static function|\}$)/s', $source, $m);
        $body = $m[0] ?? $source;
        $this->assertStringNotContainsString('rand(', $body,
            'Util::incrementalHash() still uses rand() — replace with random_int()');
        $this->assertStringContainsString('random_int(', $body,
            'Util::incrementalHash() does not use random_int()');
    }

    /** Util::random_password must use random_int, not rand */
    public function testRandomPasswordUsesRandomInt(): void
    {
        $source = file_get_contents(ROOT_PATH . 'application/config/functions.inc.php');
        preg_match('/function random_password.*?(?=public static function|\}$)/s', $source, $m);
        $body = $m[0] ?? $source;
        $this->assertStringNotContainsString('rand(', $body,
            'Util::random_password() still uses rand() — replace with random_int()');
        $this->assertStringContainsString('random_int(', $body,
            'Util::random_password() does not use random_int()');
    }

    /** Controller::getRandomPassword must use random_int, not srand/rand */
    public function testControllerPasswordUsesRandomInt(): void
    {
        $source = file_get_contents(ROOT_PATH . 'core/framework/Controller.class.php');
        preg_match('/function getRandomPassword.*?(?=function |\}$)/s', $source, $m);
        $body = $m[0] ?? $source;
        $this->assertStringNotContainsString('srand(', $body,
            'Controller::getRandomPassword() still uses srand()');
        $this->assertStringNotContainsString('rand()', $body,
            'Controller::getRandomPassword() still uses rand()');
        $this->assertStringContainsString('random_int(', $body,
            'Controller::getRandomPassword() does not use random_int()');
    }

    /** dir_chmod default must not be 0777 in uploader */
    public function testUploaderChmodNotWorldWritable(): void
    {
        $source = file_get_contents(ROOT_PATH . 'application/helpers/uploader/class.upload.php');
        // Find the var $dir_chmod property assignment (not comments)
        $stripped = preg_replace('/\/\*.*?\*\//s', '', $source); // strip block comments
        $stripped = preg_replace('/\/\/[^\n]*/', '', $stripped);  // strip line comments
        $this->assertStringNotContainsString(
            'dir_chmod = 0777',
            $stripped,
            'Uploader class.upload.php still sets dir_chmod = 0777'
        );
    }

    /** INSTALL_URL must be driven by getenv() in constants.php */
    public function testInstallUrlUsesEnv(): void
    {
        $source = file_get_contents(ROOT_PATH . 'application/config/constants.php');
        $this->assertStringContainsString('getenv(', $source,
            'INSTALL_URL not driven by getenv() in constants.php');
    }
}
