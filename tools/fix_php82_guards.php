<?php
/**
 * fix_php82_guards.php
 * Applies PHP 8.2 runtime warning guards to pujaModule:
 *   1. $_GET['key']  → $_GET['key'] ?? ''   (controllers)
 *   2. $_POST['key'] → $_POST['key'] ?? ''  (controllers + models)
 *   3. foreach ($_POST['key'] as  → foreach (($_POST['key'] ?? []) as
 *   4. foreach ($tpl['key'] as    → foreach (($tpl['key'] ?? []) as  (views)
 *   5. strtotime($tpl[..])        → strtotime($tpl[..] ?? '')         (views)
 *
 * Run: /c/xampp82/php/php tools/fix_php82_guards.php
 */

$base = __DIR__ . '/..';

$controllerFiles = glob($base . '/application/controllers/*.php');
$modelFiles      = glob($base . '/application/models/*.php');
$viewFiles       = array_merge(
    glob($base . '/application/views/*.php'),
    glob($base . '/application/views/**/*.php'),
    glob($base . '/application/views/**/**/*.php')
);

$totalFixed = 0;
$filesChanged = [];

// ─────────────────────────────────────────────────────────────────────────────
// Helper: fix one file with a set of regex transforms
// ─────────────────────────────────────────────────────────────────────────────
function fixFile(string $path, array $transforms): int {
    $original = file_get_contents($path);
    $content  = $original;

    foreach ($transforms as [$pattern, $replacement]) {
        $content = preg_replace($pattern, $replacement, $content);
    }

    if ($content !== $original) {
        file_put_contents($path, $content);
        return 1;
    }
    return 0;
}

// ─────────────────────────────────────────────────────────────────────────────
// Transform sets
// ─────────────────────────────────────────────────────────────────────────────

// Controllers + models: $_POST and $_GET guards
$superGlobalTransforms = [
    // foreach ($_POST['key'] as  →  foreach (($_POST['key'] ?? []) as
    ['/foreach\s*\(\s*\$_POST\[([\'"][^\'"]+[\'"])\]\s+as/u',
     'foreach (($_POST[$1] ?? []) as'],

    // foreach ($_GET['key'] as  →  foreach (($_GET['key'] ?? []) as
    ['/foreach\s*\(\s*\$_GET\[([\'"][^\'"]+[\'"])\]\s+as/u',
     'foreach (($_GET[$1] ?? []) as'],

    // $_POST['key'] not already followed by ??  and not inside isset()/empty()
    // We replace $_POST['key'] with $_POST['key'] ?? ''
    // Negative lookbehind: not preceded by isset( or empty(
    // Negative lookahead: not already followed by whitespace?? or ??
    ['/(?<!isset\()(?<!empty\()\$_POST\[([\'"][^\'"]+[\'"])\](?!\s*\?\?)(?!\s*\[)/u',
     '$_POST[$1] ?? \'\''],

    // $_GET['key'] not already followed by ??
    ['/(?<!isset\()(?<!empty\()\$_GET\[([\'"][^\'"]+[\'"])\](?!\s*\?\?)(?!\s*\[)/u',
     '$_GET[$1] ?? \'\''],
];

// Views: foreach $tpl guards + strtotime
$viewTransforms = [
    // foreach ($tpl['key'] as  →  foreach (($tpl['key'] ?? []) as
    ['/foreach\s*\(\s*\$tpl\[([\'"][^\'"]+[\'"])\]\s+as/u',
     'foreach (($tpl[$1] ?? []) as'],

    // foreach ($tpl['key']['subkey'] as  →  foreach (($tpl['key']['subkey'] ?? []) as
    ['/foreach\s*\(\s*\$tpl\[([\'"][^\'"]+[\'"])\]\[([\'"][^\'"]+[\'"])\]\s+as/u',
     'foreach (($tpl[$1][$2] ?? []) as'],

    // strtotime($tpl['arr']['field']) → strtotime($tpl['arr']['field'] ?? '')
    ['/strtotime\(\s*\$tpl\[([\'"][^\'"]+[\'"])\]\[([\'"][^\'"]+[\'"])\]\s*\)(?!\s*\?\?)/u',
     "strtotime(\$tpl[$1][$2] ?? '')"],
];

// ─────────────────────────────────────────────────────────────────────────────
// Process controllers
// ─────────────────────────────────────────────────────────────────────────────
echo "Processing controllers...\n";
foreach ($controllerFiles as $file) {
    $changed = fixFile($file, $superGlobalTransforms);
    if ($changed) {
        $filesChanged[] = basename($file);
        $totalFixed++;
        echo "  FIXED: " . basename($file) . "\n";
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// Process models
// ─────────────────────────────────────────────────────────────────────────────
echo "\nProcessing models...\n";
foreach ($modelFiles as $file) {
    $changed = fixFile($file, $superGlobalTransforms);
    if ($changed) {
        $filesChanged[] = basename($file);
        $totalFixed++;
        echo "  FIXED: " . basename($file) . "\n";
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// Process views
// ─────────────────────────────────────────────────────────────────────────────
echo "\nProcessing views...\n";
foreach ($viewFiles as $file) {
    $changed = fixFile($file, $viewTransforms);
    if ($changed) {
        $filesChanged[] = basename($file);
        $totalFixed++;
        echo "  FIXED: " . basename($file) . "\n";
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// Summary
// ─────────────────────────────────────────────────────────────────────────────
echo "\n========================================\n";
echo "Total files changed: $totalFixed\n";
echo "========================================\n";
