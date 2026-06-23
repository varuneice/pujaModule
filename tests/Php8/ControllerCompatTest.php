<?php
/**
 * Phase 8 — Controller PHP 8.2 Compatibility Tests (RED phase)
 *
 * Tests verify that all controllers handle edge cases safely under PHP 8.2+:
 * 1. date_default_timezone_set() is never called with a raw, unguarded value
 *    that could be null or empty string (PHP 8.1 deprecation, PHP 8.4 TypeError)
 * 2. No ${varname} string interpolation (deprecated PHP 8.2 — note: {$var} is fine)
 */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class ControllerCompatTest extends TestCase
{
    /** @return string[] list of all controller PHP files */
    private function getControllerFiles(): array
    {
        $dir = APP_PATH . 'controllers/';
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
        $files = [];
        foreach ($rii as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $files[] = $file->getPathname();
            }
        }
        return $files;
    }

    /**
     * Strip comments from PHP source so we don't catch commented-out code.
     */
    private function stripComments(string $source): string
    {
        $stripped = preg_replace('/\/\/[^\n]*/', '', $source);
        $stripped = preg_replace('/\/\*.*?\*\//s', '', $stripped);
        return $stripped;
    }

    // ---------------------------------------------------------------
    // date_default_timezone_set() null guard
    // ---------------------------------------------------------------

    /**
     * Every call to date_default_timezone_set() must use a null/empty guard
     * (either ?: 'UTC'  or  ?? 'UTC'  or  a prior if(!empty(...)) check).
     *
     * The dangerous bare pattern is:
     *   date_default_timezone_set($this->tpl['option_arr_values']['timezone'])
     * The safe pattern adds a fallback:
     *   date_default_timezone_set($this->tpl['option_arr_values']['timezone'] ?: 'UTC')
     */
    public function testNoUnguardedTimezoneSet(): void
    {
        $violations = [];
        foreach ($this->getControllerFiles() as $path) {
            $src = $this->stripComments(file_get_contents($path));
            // Match date_default_timezone_set( with the raw array access and NO fallback
            // Pattern: date_default_timezone_set( ... ['timezone'] ) -- no ?: or ?? inside
            if (preg_match(
                "/date_default_timezone_set\s*\(\s*\\\$this->tpl\['option_arr_values'\]\['timezone'\]\s*\)/",
                $src
            )) {
                $violations[] = basename($path);
            }
        }
        $this->assertEmpty(
            $violations,
            "Controllers call date_default_timezone_set() with a raw unguarded value that could be null/empty.\n" .
            "Add ?: 'UTC' fallback. Affected: " . implode(', ', $violations)
        );
    }

    // ---------------------------------------------------------------
    // ${varname} deprecated string interpolation (PHP 8.2)
    // ---------------------------------------------------------------

    /**
     * The ${varname} form of string interpolation is deprecated in PHP 8.2.
     * Note: {$var} (dollar INSIDE braces) is still valid.
     */
    public function testNoDollarCurlyStringInterpolation(): void
    {
        $violations = [];
        foreach ($this->getControllerFiles() as $path) {
            $src = $this->stripComments(file_get_contents($path));
            // Match "${ ...}" (dollar outside brace) inside a double-quoted string
            // This is a simplified heuristic — it catches the common case
            if (preg_match('/"\$\{[A-Za-z_]/', $src)) {
                $violations[] = basename($path);
            }
        }
        $this->assertEmpty(
            $violations,
            "Controllers use \${varname} string interpolation which is deprecated in PHP 8.2. " .
            "Change to {\$var} form. Affected: " . implode(', ', $violations)
        );
    }
}
