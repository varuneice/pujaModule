<?php
/**
 * Wrap raw superglobal echoes in view files with h() for XSS protection.
 * Run from project root: php tools/fix-xss-superglobals.php
 */

define('ROOT_PATH', dirname(__DIR__) . '/');
$viewDir = ROOT_PATH . 'application/views/';

$updated = 0;
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewDir));

foreach ($it as $file) {
    if (strtolower($file->getExtension()) !== 'php') {
        continue;
    }

    $path    = $file->getPathname();
    $relPath = str_replace(ROOT_PATH, '', $path);
    $content = file_get_contents($path);
    $new     = $content;

    // Pattern 1: echo $_GET['key'], echo $_POST['key'], echo $_REQUEST['key']
    // -> echo h($_GET['key'])
    $new = preg_replace_callback(
        '/\becho\s+(\$_(GET|POST|REQUEST)\[\'[^\']+\'\])/i',
        function ($m) {
            return 'echo h(' . $m[1] . ')';
        },
        $new
    );

    // Pattern 2: echo $_GET["key"], echo $_POST["key"] (double quotes)
    $new = preg_replace_callback(
        '/\becho\s+(\$_(GET|POST|REQUEST)\["[^"]+"\])/i',
        function ($m) {
            return 'echo h(' . $m[1] . ')';
        },
        $new
    );

    if ($new === $content) {
        continue;
    }

    file_put_contents($path, $new);
    echo "OK    $relPath\n";
    $updated++;
}

echo "\nDone. Updated: $updated files.\n";
