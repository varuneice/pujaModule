<?php
/**
 * fix_hardcoded_urls.php
 * Replaces all hardcoded http://localhost:8082/HDBS_Payment/pujaModule/
 * with the INSTALL_URL constant or <?php echo INSTALL_URL; ?> as appropriate.
 *
 * Patterns handled:
 *   href="URL/suffix"         → href="<?php echo INSTALL_URL; ?>suffix"
 *   href='URL/suffix'         → href='<?php echo INSTALL_URL; ?>suffix'
 *   action="URL/suffix"       → action="<?php echo INSTALL_URL; ?>suffix"
 *   src="URL/suffix"          → src="<?php echo INSTALL_URL; ?>suffix"
 *   document.location.href='URL/suffix' → ...='<?php echo INSTALL_URL; ?>suffix'
 *   window.location='URL...'  → similar
 *   $var = "URL/suffix"       → $var = INSTALL_URL . "suffix"
 *   $var = 'URL/suffix'       → $var = INSTALL_URL . 'suffix'
 *   echo "...URL/suffix..."   → echo "..." . INSTALL_URL . "suffix..."
 */

$BASE_URL = 'http://localhost:8082/HDBS_Payment/pujaModule/';

$files = array_merge(
    glob(__DIR__ . '/../application/controllers/*.php'),
    glob(__DIR__ . '/../application/views/*.php'),
    glob(__DIR__ . '/../application/views/**/*.php'),
    glob(__DIR__ . '/../application/views/**/**/*.php')
);

$totalFixed = 0;

foreach ($files as $path) {
    $original = file_get_contents($path);
    if (strpos($original, $BASE_URL) === false) continue;

    $lines   = explode("\n", $original);
    $changed = false;

    foreach ($lines as &$line) {
        if (strpos($line, $BASE_URL) === false) continue;

        $new = $line;

        // ── HTML attribute: href/action/src with double quotes ─────────────
        $new = preg_replace(
            '/(href|action|src|data-url)="' . preg_quote($BASE_URL, '/') . '([^"]*)"/u',
            '$1="<?php echo INSTALL_URL; ?>$2"',
            $new
        );
        // ── HTML attribute: href/action/src with single quotes ─────────────
        $new = preg_replace(
            "/(href|action|src|data-url)='" . preg_quote($BASE_URL, '/') . "([^']*)'/u",
            "\$1='<?php echo INSTALL_URL; ?>\$2'",
            $new
        );

        // ── JavaScript: document.location.href = 'URL...' ─────────────────
        $new = preg_replace(
            "/(document\.location(?:\.href)?\s*=\s*)'(" . preg_quote($BASE_URL, '/') . ")([^']*)'/u",
            "\$1'<?php echo INSTALL_URL; ?>\$3'",
            $new
        );
        $new = preg_replace(
            '/(document\.location(?:\.href)?\s*=\s*)"(' . preg_quote($BASE_URL, '/') . ')([^"]*)"/u',
            '$1"<?php echo INSTALL_URL; ?>$3"',
            $new
        );
        // window.location
        $new = preg_replace(
            "/(window\.location(?:\.href)?\s*=\s*)'(" . preg_quote($BASE_URL, '/') . ")([^']*)'/u",
            "\$1'<?php echo INSTALL_URL; ?>\$3'",
            $new
        );

        // ── PHP variable assignment: $var = "URL..." ───────────────────────
        $new = preg_replace(
            '/(\$\w+\s*=\s*)"' . preg_quote($BASE_URL, '/') . '([^"]*)"/u',
            '$1INSTALL_URL . "$2"',
            $new
        );
        $new = preg_replace(
            "/(\\\$\\w+\\s*=\\s*)'" . preg_quote($BASE_URL, '/') . "([^']*)'/u",
            "\$1INSTALL_URL . '\$2'",
            $new
        );

        // ── PHP echo: echo "...URL..." ─────────────────────────────────────
        // echo "prefix URL/suffix more"  →  echo "prefix " . INSTALL_URL . "suffix more"
        $new = preg_replace(
            '/(echo\s+"[^"]*)"' . preg_quote($BASE_URL, '/') . '([^"]*")/u',
            '$1" . INSTALL_URL . "$2',
            $new
        );
        $new = preg_replace(
            "/(echo\\s+'[^']*)'(" . preg_quote($BASE_URL, '/') . ")([^']*')/u",
            "\$1' . INSTALL_URL . '\$3",
            $new
        );

        // ── Any remaining bare URL in double/single quotes ─────────────────
        $new = preg_replace(
            '/"' . preg_quote($BASE_URL, '/') . '([^"]*)"/u',
            'INSTALL_URL . "$1"',
            $new
        );
        $new = preg_replace(
            "/'(" . preg_quote($BASE_URL, '/') . ")([^']*)'/u",
            "INSTALL_URL . '\$2'",
            $new
        );

        if ($new !== $line) {
            $line    = $new;
            $changed = true;
        }
    }
    unset($line);

    if ($changed) {
        file_put_contents($path, implode("\n", $lines));
        $totalFixed++;
        echo "  FIXED: " . str_replace(__DIR__ . '/../', '', $path) . "\n";
    }
}

echo "\nTotal files fixed: $totalFixed\n";
