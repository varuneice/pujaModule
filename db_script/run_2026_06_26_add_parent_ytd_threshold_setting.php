<?php

require_once __DIR__ . '/../config.php';

header('Content-Type: text/html; charset=utf-8');

function renderPage($title, $body)
{
    echo '<!doctype html><html><head><meta charset="utf-8"><title>' . htmlspecialchars($title, ENT_QUOTES) . '</title>';
    echo '<style>body{font-family:Arial,sans-serif;margin:40px;line-height:1.5}.box{max-width:760px;border:1px solid #ddd;padding:24px;border-radius:6px}.btn{display:inline-block;background:#0d6efd;color:#fff;padding:10px 16px;text-decoration:none;border-radius:4px}.ok{color:#0a7a35}.err{color:#b00020}code{background:#f4f4f4;padding:2px 5px}</style>';
    echo '</head><body><div class="box">' . $body . '</div></body></html>';
}

if (($_GET['run'] ?? '') !== '1') {
    renderPage(
        'Parent YTD Threshold DB Script',
        '<h2>Parent YTD Threshold DB Script</h2>
        <p>This will create/update <code>puja_registration_settings</code> and set <code>parent_ytd_threshold</code> to <code>749</code> for the current year.</p>
        <p><a class="btn" href="?run=1">Run DB Script</a></p>'
    );
    exit;
}

if (!isset($con) || !($con instanceof mysqli)) {
    http_response_code(500);
    renderPage('DB Script Failed', '<h2 class="err">FAILED</h2><p>Database connection not available.</p>');
    exit;
}

$seasonYear = (int) date('Y');
$threshold = '749';
$now = date('Y-m-d H:i:s');

try {
    $createTableSql = "CREATE TABLE IF NOT EXISTS `puja_registration_settings` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `season_year` int(11) NOT NULL,
        `setting_key` varchar(100) NOT NULL,
        `setting_value` varchar(255) NOT NULL,
        `active` tinyint(1) NOT NULL DEFAULT 1,
        `created_at` datetime DEFAULT NULL,
        `updated_at` datetime DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `uniq_puja_registration_setting` (`season_year`, `setting_key`),
        KEY `idx_puja_registration_settings_active` (`active`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
    $con->query($createTableSql);

    $stmt = $con->prepare("INSERT INTO `puja_registration_settings`
        (`season_year`, `setting_key`, `setting_value`, `active`, `created_at`, `updated_at`)
        VALUES (?, 'parent_ytd_threshold', ?, 1, ?, ?)
        ON DUPLICATE KEY UPDATE
            `setting_value` = VALUES(`setting_value`),
            `active` = 1,
            `updated_at` = VALUES(`updated_at`)");
    $stmt->bind_param('isss', $seasonYear, $threshold, $now, $now);
    $stmt->execute();
    $stmt->close();

    renderPage(
        'DB Script Success',
        '<h2 class="ok">SUCCESS</h2>
        <p>Setting saved successfully.</p>
        <p><code>parent_ytd_threshold=' . htmlspecialchars($threshold, ENT_QUOTES) . '</code></p>
        <p><code>season_year=' . htmlspecialchars((string) $seasonYear, ENT_QUOTES) . '</code></p>'
    );
} catch (Throwable $e) {
    http_response_code(500);
    renderPage('DB Script Failed', '<h2 class="err">FAILED</h2><p>' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '</p>');
}
