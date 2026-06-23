<?php
/**
 * Add CSRF hidden input to every POST form in the views directory.
 * Skips files that already have csrf_token.
 * Skips Installer views (exempt from CSRF validation).
 * Run from project root: php tools/add-csrf-tokens.php
 */

define('ROOT_PATH', dirname(__DIR__) . '/');
$viewDir   = ROOT_PATH . 'application/views/';
$csrfField = PHP_EOL . '<input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION[\'csrf_token\'] ?? \'\', ENT_QUOTES, \'UTF-8\') ?>">';

$updated = 0;
$skipped = 0;

$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewDir));

foreach ($it as $file) {
    if ($file->getExtension() !== 'php') { continue; }

    $path    = $file->getPathname();
    $relPath = str_replace(ROOT_PATH, '', $path);

    // Skip Installer views — exempt from CSRF validation
    if (str_contains($path, DIRECTORY_SEPARATOR . 'Installer' . DIRECTORY_SEPARATOR)) {
        continue;
    }

    $content = file_get_contents($path);

    // Skip if no POST form
    if (!preg_match('/<form[^>]+method=["\']?post["\']?/i', $content)) {
        continue;
    }

    // Skip if token already present
    if (str_contains($content, 'csrf_token')) {
        $skipped++;
        continue;
    }

    // Inject hidden field immediately after each opening <form ...> POST tag
    $new = preg_replace_callback(
        '/(<form[^>]+method=["\']?post["\']?[^>]*>)/i',
        function ($matches) use ($csrfField) {
            return $matches[1] . $csrfField;
        },
        $content
    );

    if ($new === $content) {
        echo "WARN  (no change): $relPath\n";
        continue;
    }

    file_put_contents($path, $new);
    echo "OK    $relPath\n";
    $updated++;
}

echo "\nDone. Updated: $updated  |  Already had token: $skipped\n";
