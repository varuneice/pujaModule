<?php
/**
 * Fix CSRF tokens that were injected inside form action="..." attributes.
 *
 * The broken pattern (two consecutive lines) is:
 *   action="[PHP-ECHO-INSTALL-URL]
 *   <input type="hidden" name="csrf_token" value="...">REST_URL">
 *
 * The correct pattern is:
 *   action="[PHP-ECHO-INSTALL-URL]REST_URL">
 *   <input type="hidden" name="csrf_token" value="...">
 */

$viewsDir = dirname(__DIR__) . '/application/views/';
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsDir));

$totalFixed = 0;
$filesFixed = 0;

foreach ($rii as $file) {
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $src = file_get_contents($file->getPathname());

    // Build the PHP open/close tags dynamically to avoid them being
    // interpreted by PHP's own parser when reading this tool file.
    $phpOpen  = '<' . '?php';
    $phpClose = '?' . '>';
    $phpEcho  = '<' . '?=';

    // Pattern: action="[php echo INSTALL_URL]" appears, then on the next
    // line the csrf input is there, followed by the rest of the URL, then ">.
    //
    // Regex groups:
    //   $m[1] = the action="[php echo INSTALL_URL]" part (opening of action attr)
    //   $m[2] = any whitespace indent on the broken line
    //   $m[3] = the full <input ... csrf_token ...> tag
    //   $m[4] = the rest of the URL after the csrf tag

    $installUrlPhp = 'action="' . $phpOpen . ' echo INSTALL_URL; ' . $phpClose;

    $pattern = '/(' . preg_quote($installUrlPhp, '/') . ')' .
               '\r?\n' .
               '(\s*)' .
               '(<input[^>]+name="csrf_token"[^>]*>)' .
               '([^"]*)' .
               '">/';

    $new = preg_replace_callback($pattern, function ($m) {
        $actionPart = $m[1]; // action="[php echo INSTALL_URL]
        $indent     = $m[2]; // whitespace indent
        $csrfField  = $m[3]; // csrf input tag
        $urlRest    = $m[4]; // ?controller=foo&action=bar

        return $actionPart . $urlRest . '">' . "\n" . $indent . $csrfField;
    }, $src, -1, $count);

    if ($count > 0) {
        file_put_contents($file->getPathname(), $new);
        $totalFixed += $count;
        $filesFixed++;
        $rel = str_replace($viewsDir, '', $file->getPathname());
        echo "  [{$count}] " . $rel . "\n";
    }
}

echo "\nDone: {$totalFixed} fix(es) in {$filesFixed} file(s).\n";
