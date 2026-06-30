<?php

require_once __DIR__ . '/../config.php';

header('Content-Type: text/html; charset=utf-8');

function renderPage($title, $body)
{
    echo '<!doctype html><html><head><meta charset="utf-8"><title>' . htmlspecialchars($title, ENT_QUOTES) . '</title>';
    echo '<style>body{font-family:Arial,sans-serif;margin:40px;line-height:1.5}.box{max-width:900px;border:1px solid #ddd;padding:24px;border-radius:6px}.btn{display:inline-block;background:#0d6efd;color:#fff;padding:10px 16px;text-decoration:none;border-radius:4px}.ok{color:#0a7a35}.err{color:#b00020}code{background:#f4f4f4;padding:2px 5px}li{margin:6px 0}</style>';
    echo '</head><body><div class="box">' . $body . '</div></body></html>';
}

function columnExists(mysqli $con, $table, $column)
{
    $stmt = $con->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?");
    $stmt->bind_param('ss', $table, $column);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return (int) $count > 0;
}

function addColumnIfMissing(mysqli $con, $table, $column, $definition, &$messages)
{
    if (columnExists($con, $table, $column)) {
        $messages[] = '<li><code>' . htmlspecialchars($table . '.' . $column, ENT_QUOTES) . '</code> already exists.</li>';
        return;
    }

    $sql = 'ALTER TABLE `' . $table . '` ADD COLUMN `' . $column . '` ' . $definition;
    if (!$con->query($sql)) {
        throw new RuntimeException($con->error);
    }
    $messages[] = '<li>Added <code>' . htmlspecialchars($table . '.' . $column, ENT_QUOTES) . '</code>.</li>';
}

function updateParentPrice(mysqli $con, $likePattern, $parentPrice, &$messages)
{
    $stmt = $con->prepare("UPDATE `pujapassesprice` SET `parentprice` = ? WHERE `pujaname` LIKE ?");
    $stmt->bind_param('ss', $parentPrice, $likePattern);
    $stmt->execute();
    $affected = $stmt->affected_rows;
    $stmt->close();
    $messages[] = '<li>Set parent price <code>$' . htmlspecialchars($parentPrice, ENT_QUOTES) . '</code> for <code>' . htmlspecialchars($likePattern, ENT_QUOTES) . '</code>. Rows changed: <code>' . htmlspecialchars((string) $affected, ENT_QUOTES) . '</code>.</li>';
}

function updateParentPriceByPrice(mysqli $con, $likePattern, $basePrices, $parentPrice, &$messages)
{
    $firstPrice = (string) ($basePrices[0] ?? '');
    $secondPrice = (string) ($basePrices[1] ?? '');
    $stmt = $con->prepare("UPDATE `pujapassesprice` SET `parentprice` = ? WHERE `pujaname` LIKE ? AND (`price` = ? OR `price` = ?)");
    $stmt->bind_param('ssss', $parentPrice, $likePattern, $firstPrice, $secondPrice);
    $stmt->execute();
    $affected = $stmt->affected_rows;
    $stmt->close();
    $messages[] = '<li>Set parent price <code>$' . htmlspecialchars($parentPrice, ENT_QUOTES) . '</code> for <code>' . htmlspecialchars($likePattern, ENT_QUOTES) . '</code> with base prices <code>' . htmlspecialchars(implode(', ', $basePrices), ENT_QUOTES) . '</code>. Rows changed: <code>' . htmlspecialchars((string) $affected, ENT_QUOTES) . '</code>.</li>';
}

if (($_GET['run'] ?? '') !== '1') {
    renderPage(
        'Paid Passes Parent DB Script',
        '<h2>Paid Passes Parent DB Script</h2>
        <p>This will add missing parent fields for <code>pujapasses</code>, add <code>pujapassesprice.parentprice</code>, and set the parent prices from the latest pass price list.</p>
        <p>No application logic is changed by this script. It only updates the database schema/data when you click run.</p>
        <p><a class="btn" href="?run=1">Run DB Script</a></p>'
    );
    exit;
}

if (!isset($con) || !($con instanceof mysqli)) {
    http_response_code(500);
    renderPage('DB Script Failed', '<h2 class="err">FAILED</h2><p>Database connection not available.</p>');
    exit;
}

$messages = array();

try {
    addColumnIfMissing($con, 'pujapasses', 'no_of_parent', 'varchar(10) DEFAULT NULL AFTER `senior_veggie`', $messages);
    addColumnIfMissing($con, 'pujapasses', 'parent1_fname', 'varchar(100) DEFAULT NULL AFTER `no_of_parent`', $messages);
    addColumnIfMissing($con, 'pujapasses', 'parent1_lname', 'varchar(100) DEFAULT NULL AFTER `parent1_fname`', $messages);
    addColumnIfMissing($con, 'pujapasses', 'parent1_veggie', 'tinyint(1) DEFAULT 0 AFTER `parent1_lname`', $messages);
    addColumnIfMissing($con, 'pujapasses', 'parent2_fname', 'varchar(100) DEFAULT NULL AFTER `parent1_veggie`', $messages);
    addColumnIfMissing($con, 'pujapasses', 'parent2_lname', 'varchar(100) DEFAULT NULL AFTER `parent2_fname`', $messages);
    addColumnIfMissing($con, 'pujapasses', 'parent2_veggie', 'tinyint(1) DEFAULT 0 AFTER `parent2_lname`', $messages);
    addColumnIfMissing($con, 'pujapasses', 'extraparentregistration', 'varchar(50) DEFAULT NULL AFTER `status`', $messages);
    addColumnIfMissing($con, 'pujapassesprice', 'parentprice', 'varchar(50) DEFAULT NULL AFTER `price`', $messages);

    updateParentPrice($con, '%Friday%Oct%16%Evening%', '50', $messages);
    updateParentPrice($con, '%DP%Friday%Evening%', '50', $messages);

    updateParentPrice($con, '%Saturday%Oct%17%Day%', '65', $messages);
    updateParentPrice($con, '%DP%Saturday%Day%', '65', $messages);

    updateParentPrice($con, '%Saturday%Oct%17%Evening%', '60', $messages);
    updateParentPriceByPrice($con, '%DP%Saturday%Evening%', array('240', '120'), '60', $messages);

    updateParentPrice($con, '%Sunday%Oct%18%Day%', '35', $messages);
    updateParentPrice($con, '%DP%Sunday%Day%', '35', $messages);

    updateParentPrice($con, '%Saturday%Oct%24%Evening%', '65', $messages);
    updateParentPriceByPrice($con, '%DP%Saturday%Evening%', array('260', '130'), '65', $messages);

    updateParentPrice($con, '%Saturday%Nov%7%Evening%', '45', $messages);
    updateParentPrice($con, '%KP%Saturday%Evening%', '45', $messages);

    renderPage(
        'DB Script Success',
        '<h2 class="ok">SUCCESS</h2><p>Paid Passes parent fields and prices are ready.</p><ul>' . implode('', $messages) . '</ul>'
    );
} catch (Throwable $e) {
    http_response_code(500);
    renderPage('DB Script Failed', '<h2 class="err">FAILED</h2><p>' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '</p><ul>' . implode('', $messages) . '</ul>');
}
