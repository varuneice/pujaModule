<?php
/**
 * fix_php82_guards2.php
 * Fixes problems introduced by fix_php82_guards.php:
 *
 *  1. $_POST['key'] ?? '' = value   → $_POST['key'] = value  (restore lvalue assignments)
 *  2. unset($_POST['key'] ?? '')    → unset($_POST['key'])
 *  3. unset($_GET['key'] ?? '')     → unset($_GET['key'])
 *  4. $_POST['key'] ?? '' == 'x'   → ($_POST['key'] ?? '') == 'x'  (wrap for precedence)
 *  5. $_POST['key'] ?? '' != 'x'   → ($_POST['key'] ?? '') != 'x'
 *  6. $_POST['key'] ?? '' === 'x'  → ($_POST['key'] ?? '') === 'x'
 *  7. $_POST['key'] ?? '' !== 'x'  → ($_POST['key'] ?? '') !== 'x'
 *  8. Same for $_GET
 */

$base = __DIR__ . '/..';

$files = array_merge(
    glob($base . '/application/controllers/*.php'),
    glob($base . '/application/models/*.php'),
    glob($base . '/application/views/*.php'),
    glob($base . '/application/views/**/*.php'),
    glob($base . '/application/views/**/**/*.php')
);

$totalFixed = 0;

foreach ($files as $path) {
    $original = file_get_contents($path);
    $content  = $original;

    // ── 1. Restore lvalue: $_POST['key'] ?? '' = value  →  $_POST['key'] = value
    $content = preg_replace(
        '/(\$_POST\[[\'"][^\'"]+[\'"]\])\s*\?\?\s*\'\'\s*(?==\s*(?!=))/u',
        '$1 ',
        $content
    );
    $content = preg_replace(
        '/(\$_GET\[[\'"][^\'"]+[\'"]\])\s*\?\?\s*\'\'\s*(?==\s*(?!=))/u',
        '$1 ',
        $content
    );

    // ── 2. Restore unset(): unset($_POST['key'] ?? '')  →  unset($_POST['key'])
    $content = preg_replace(
        '/unset\s*\(\s*(\$_POST\[[\'"][^\'"]+[\'"]\])\s*\?\?\s*\'\'(\s*,|\s*\))/u',
        'unset($1$2',
        $content
    );
    $content = preg_replace(
        '/unset\s*\(\s*(\$_GET\[[\'"][^\'"]+[\'"]\])\s*\?\?\s*\'\'(\s*,|\s*\))/u',
        'unset($1$2',
        $content
    );

    // ── 3. Fix comparison precedence: X ?? '' == Y  →  (X ?? '') == Y
    //    Match: $_POST/GET['key'] ?? '' followed by ==, !=, ===, !==, <, >, <=, >=
    $content = preg_replace(
        '/(\$_POST\[[\'"][^\'"]+[\'"]\]\s*\?\?\s*\'\')\s*(===|!==|==|!=|<=|>=|<|>)/u',
        '($1) $2',
        $content
    );
    $content = preg_replace(
        '/(\$_GET\[[\'"][^\'"]+[\'"]\]\s*\?\?\s*\'\')\s*(===|!==|==|!=|<=|>=|<|>)/u',
        '($1) $2',
        $content
    );

    if ($content !== $original) {
        file_put_contents($path, $content);
        $totalFixed++;
        echo "  FIXED: " . basename($path) . "\n";
    }
}

echo "\nTotal files cleaned up: $totalFixed\n";
