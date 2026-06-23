<?php
/**
 * Phase 6 — Library Upgrade Tests (RED phase)
 *
 * These tests verify that:
 * 1. PHPMailer is loaded via Composer (v6+), not the bundled PHPMailer_5.2.4 directory
 * 2. mPDF is loaded via Composer (v8+), not the bundled MPDF57 directory
 * 3. Legacy bundled library directories have been removed
 * 4. All App.php email blocks use the new namespaced PHPMailer class
 */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class LibraryTest extends TestCase
{
    // ---------------------------------------------------------------
    // PHPMailer
    // ---------------------------------------------------------------

    /** Bundled PHPMailer 5.x directory must be gone */
    public function testLegacyPhpMailerDirectoryRemoved(): void
    {
        $legacy = ROOT_PATH . 'application/helpers/PHPMailer_5.2.4';
        $this->assertDirectoryDoesNotExist(
            $legacy,
            'Legacy PHPMailer_5.2.4 directory still present — delete it'
        );
    }

    /** Composer autoload must be present (prerequisite for all Composer libs) */
    public function testComposerVendorAutoloadExists(): void
    {
        $autoload = ROOT_PATH . 'vendor/autoload.php';
        $this->assertFileExists(
            $autoload,
            'vendor/autoload.php missing — run: composer install'
        );
    }

    /** PHPMailer 6.x class must be loadable via Composer autoload */
    public function testPhpMailer6ClassExists(): void
    {
        $autoload = ROOT_PATH . 'vendor/autoload.php';
        if (file_exists($autoload)) {
            require_once $autoload;
        }
        $this->assertTrue(
            class_exists('\PHPMailer\PHPMailer\PHPMailer'),
            'PHPMailer\\PHPMailer\\PHPMailer class not found — add phpmailer/phpmailer:^6 to composer.json and run composer install'
        );
    }

    /** PHPMailer version must be 6.x or higher */
    public function testPhpMailer6Version(): void
    {
        $autoload = ROOT_PATH . 'vendor/autoload.php';
        if (file_exists($autoload)) {
            require_once $autoload;
        }
        if (!class_exists('\PHPMailer\PHPMailer\PHPMailer')) {
            $this->markTestSkipped('PHPMailer not installed via Composer yet');
        }
        $version = \PHPMailer\PHPMailer\PHPMailer::VERSION;
        $this->assertGreaterThanOrEqual(
            6,
            (int) $version,
            "PHPMailer version $version is too old — need ^6"
        );
    }

    /** App.php must NOT contain old require_once for PHPMailer_5.2.4 */
    public function testAppPhpNoLegacyPhpMailerRequire(): void
    {
        $appFile = APP_PATH . 'controllers/App.php';
        if (!file_exists($appFile)) {
            $this->markTestSkipped('App.php not found');
        }
        $source = file_get_contents($appFile);
        $this->assertStringNotContainsString(
            'PHPMailer_5.2.4',
            $source,
            'App.php still requires legacy PHPMailer_5.2.4 — replace with Composer autoload + use statements'
        );
    }

    /** App.php must import PHPMailer\PHPMailer\Exception (either directly or via alias) */
    public function testAppPhpUsesNamespacedPhpMailerException(): void
    {
        $appFile = APP_PATH . 'controllers/App.php';
        if (!file_exists($appFile)) {
            $this->markTestSkipped('App.php not found');
        }
        $source = file_get_contents($appFile);
        // Must have a proper use import for PHPMailer\PHPMailer\Exception
        $this->assertMatchesRegularExpression(
            '/use PHPMailer\\\\PHPMailer\\\\Exception/',
            $source,
            'App.php must import PHPMailer\\PHPMailer\\Exception via a use statement'
        );
        // Must NOT have a bare require of the old file (no use alias, just loading old file)
        $this->assertStringNotContainsString(
            'class.phpmailer.php',
            $source,
            'App.php still directly requires class.phpmailer.php from PHPMailer 5'
        );
    }

    /** Invoice.php must NOT contain old require_once for PHPMailer_5.2.4 */
    public function testInvoicePhpNoLegacyPhpMailerRequire(): void
    {
        $invoiceFile = APP_PATH . 'controllers/Invoice.php';
        if (!file_exists($invoiceFile)) {
            $this->markTestSkipped('Invoice.php not found');
        }
        $source = file_get_contents($invoiceFile);
        $this->assertStringNotContainsString(
            'PHPMailer_5.2.4',
            $source,
            'Invoice.php still requires legacy PHPMailer_5.2.4 — replace with Composer autoload + use statements'
        );
    }

    // ---------------------------------------------------------------
    // mPDF
    // ---------------------------------------------------------------

    /** Bundled MPDF57 directory must be gone */
    public function testLegacyMpdfDirectoryRemoved(): void
    {
        $legacy = ROOT_PATH . 'application/helpers/MPDF57';
        $this->assertDirectoryDoesNotExist(
            $legacy,
            'Legacy MPDF57 directory still present — delete it'
        );
    }

    /** mPDF 8.x class must be loadable via Composer autoload */
    public function testMpdf8ClassExists(): void
    {
        $autoload = ROOT_PATH . 'vendor/autoload.php';
        if (file_exists($autoload)) {
            require_once $autoload;
        }
        $this->assertTrue(
            class_exists('\Mpdf\Mpdf'),
            '\\Mpdf\\Mpdf class not found — add mpdf/mpdf:^8 to composer.json and run composer install'
        );
    }

    /** Foodcoupon.php must NOT include old MPDF57 path */
    public function testFoodcouponPhpNoLegacyMpdfInclude(): void
    {
        $file = APP_PATH . 'controllers/Foodcoupon.php';
        if (!file_exists($file)) {
            $this->markTestSkipped('Foodcoupon.php not found');
        }
        $source = file_get_contents($file);
        $this->assertStringNotContainsString(
            'MPDF57',
            $source,
            'Foodcoupon.php still includes legacy MPDF57 — replace with Composer autoload + new \\Mpdf\\Mpdf()'
        );
    }

    // ---------------------------------------------------------------
    // index.php bootstraps Composer autoload
    // ---------------------------------------------------------------

    /** index.php must require vendor/autoload.php */
    public function testIndexPhpRequiresVendorAutoload(): void
    {
        $source = file_get_contents(ROOT_PATH . 'index.php');
        $this->assertStringContainsString(
            'vendor/autoload.php',
            $source,
            'index.php does not require vendor/autoload.php — Composer libraries will not load'
        );
    }
}
