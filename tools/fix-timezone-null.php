<?php
/**
 * Fix all unguarded date_default_timezone_set() calls in controllers.
 * PHP 8.1+ deprecates passing null; PHP 8.4 throws TypeError on null/empty.
 * Adds ?: 'UTC' fallback so an unconfigured timezone never breaks the app.
 */

$find    = "date_default_timezone_set(\$this->tpl['option_arr_values']['timezone']);";
$replace = "date_default_timezone_set(\$this->tpl['option_arr_values']['timezone'] ?: 'UTC');";

$dir = dirname(__DIR__) . '/application/controllers/';
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

$totalFixed = 0;
$filesFixed = 0;

foreach ($rii as $file) {
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $src   = file_get_contents($file->getPathname());
    $count = substr_count($src, $find);

    if ($count > 0) {
        $new = str_replace($find, $replace, $src);
        file_put_contents($file->getPathname(), $new);
        $totalFixed += $count;
        $filesFixed++;
        echo "  [{$count}] " . basename($file->getPathname()) . "\n";
    }
}

echo "\nDone: {$totalFixed} occurrence(s) fixed in {$filesFixed} file(s).\n";
