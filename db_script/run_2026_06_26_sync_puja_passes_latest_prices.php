<?php

require_once __DIR__ . '/../config.php';

header('Content-Type: text/html; charset=utf-8');

function renderPage($title, $body)
{
    echo '<!doctype html><html><head><meta charset="utf-8"><title>' . htmlspecialchars($title, ENT_QUOTES) . '</title>';
    echo '<style>body{font-family:Arial,sans-serif;margin:40px;line-height:1.5}.box{max-width:980px;border:1px solid #ddd;padding:24px;border-radius:6px}.btn{display:inline-block;background:#0d6efd;color:#fff;padding:10px 16px;text-decoration:none;border-radius:4px}.ok{color:#0a7a35}.err{color:#b00020}code{background:#f4f4f4;padding:2px 5px}table{border-collapse:collapse;width:100%;margin-top:16px}th,td{border:1px solid #ddd;padding:8px;text-align:left}th{background:#f6f6f6}</style>';
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

function addParentPriceColumnIfMissing(mysqli $con)
{
    if (columnExists($con, 'pujapassesprice', 'parentprice')) {
        return false;
    }

    if (!$con->query("ALTER TABLE `pujapassesprice` ADD COLUMN `parentprice` varchar(50) DEFAULT NULL AFTER `price`")) {
        throw new RuntimeException($con->error);
    }
    return true;
}

function addColumnIfMissing(mysqli $con, $table, $column, $definition)
{
    if (columnExists($con, $table, $column)) {
        return 'already existed';
    }

    $sql = 'ALTER TABLE `' . $table . '` ADD COLUMN `' . $column . '` ' . $definition;
    if (!$con->query($sql)) {
        throw new RuntimeException($con->error);
    }
    return 'added';
}

function deleteOldRowsNotInLatestList(mysqli $con, $latestNames)
{
    $placeholders = implode(',', array_fill(0, count($latestNames), '?'));
    $sql = "DELETE FROM `pujapassesprice` WHERE `pujaname` NOT IN ($placeholders)";
    $stmt = $con->prepare($sql);

    if (count($latestNames) === 6) {
        $stmt->bind_param(
            'ssssss',
            $latestNames[0],
            $latestNames[1],
            $latestNames[2],
            $latestNames[3],
            $latestNames[4],
            $latestNames[5]
        );
    } else {
        throw new RuntimeException('Latest pass name list must contain exactly 6 items.');
    }

    $stmt->execute();
    $deleted = max(0, $stmt->affected_rows);
    $stmt->close();

    return $deleted;
}

function upsertPassPrice(mysqli $con, $pujaname, $pricefor, $pricetype, $price, $parentprice)
{
    $stmt = $con->prepare("SELECT `id` FROM `pujapassesprice` WHERE `pujaname` = ? AND `pricefor` = ? AND `pricetype` = ? LIMIT 1");
    $stmt->bind_param('sss', $pujaname, $pricefor, $pricetype);
    $stmt->execute();
    $stmt->bind_result($id);
    $found = $stmt->fetch();
    $stmt->close();

    if ($found && $id) {
        $stmt = $con->prepare("UPDATE `pujapassesprice` SET `price` = ?, `parentprice` = ? WHERE `id` = ?");
        $stmt->bind_param('ssi', $price, $parentprice, $id);
        $stmt->execute();
        $stmt->close();
        return 'updated';
    }

    $stmt = $con->prepare("INSERT INTO `pujapassesprice` (`pujaname`, `pricefor`, `pricetype`, `price`, `parentprice`) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssss', $pujaname, $pricefor, $pricetype, $price, $parentprice);
    $stmt->execute();
    $stmt->close();
    return 'inserted';
}

$passes = array(
    'DP Friday Oct 16 Evening' => array('family' => '200', 'individual' => '100', 'parentprice' => '50'),
    'DP Saturday Oct 17 Day' => array('family' => '260', 'individual' => '130', 'parentprice' => '65'),
    'DP Saturday Oct 17 Evening' => array('family' => '240', 'individual' => '120', 'parentprice' => '60'),
    'DP Sunday Oct 18 Day' => array('family' => '130', 'individual' => '70', 'parentprice' => '35'),
    'DP Saturday Oct 24 Evening' => array('family' => '260', 'individual' => '130', 'parentprice' => '65'),
    'KP Saturday Nov 7 Evening' => array('family' => '175', 'individual' => '90', 'parentprice' => '45'),
);

$priceForList = array('member', 'nonmember', 'outoftowner');
$priceTypeList = array('family', 'individual');

if (($_GET['run'] ?? '') !== '1') {
    $latestNames = array_keys($passes);
    $rows = '';
    foreach ($passes as $name => $prices) {
        $rows .= '<tr><td>' . htmlspecialchars($name, ENT_QUOTES) . '</td><td>' . htmlspecialchars($prices['family'], ENT_QUOTES) . '</td><td>' . htmlspecialchars($prices['individual'], ENT_QUOTES) . '</td><td>' . htmlspecialchars($prices['parentprice'], ENT_QUOTES) . '</td></tr>';
    }

    renderPage(
        'Sync Puja Passes Latest Prices',
        '<h2>Sync Puja Passes Latest Prices</h2>
        <p>This will add paid passes parent fields to <code>pujapasses</code> and sync <code>pujapassesprice</code> with the latest pass list.</p>
        <p>It will create/update 36 rows: 6 pass names x 3 price-for values x 2 price types.</p>
        <p>It will delete every old <code>pujapassesprice</code> row whose <code>pujaname</code> is not one of the latest 6 pass names.</p>
        <table><thead><tr><th>Pass</th><th>Family</th><th>Individual</th><th>Parent</th></tr></thead><tbody>' . $rows . '</tbody></table>
        <p>Latest names kept: <code>' . htmlspecialchars(implode(', ', $latestNames), ENT_QUOTES) . '</code></p>
        <p><a class="btn" href="?run=1">Run Sync Script</a></p>'
    );
    exit;
}

if (!isset($con) || !($con instanceof mysqli)) {
    http_response_code(500);
    renderPage('DB Script Failed', '<h2 class="err">FAILED</h2><p>Database connection not available.</p>');
    exit;
}

try {
    $paidPassColumnResults = array(
        'pujapasses.no_of_parent' => addColumnIfMissing($con, 'pujapasses', 'no_of_parent', 'varchar(10) DEFAULT NULL AFTER `senior_veggie`'),
        'pujapasses.parent1_fname' => addColumnIfMissing($con, 'pujapasses', 'parent1_fname', 'varchar(100) DEFAULT NULL AFTER `no_of_parent`'),
        'pujapasses.parent1_lname' => addColumnIfMissing($con, 'pujapasses', 'parent1_lname', 'varchar(100) DEFAULT NULL AFTER `parent1_fname`'),
        'pujapasses.parent1_veggie' => addColumnIfMissing($con, 'pujapasses', 'parent1_veggie', 'tinyint(1) DEFAULT 0 AFTER `parent1_lname`'),
        'pujapasses.parent2_fname' => addColumnIfMissing($con, 'pujapasses', 'parent2_fname', 'varchar(100) DEFAULT NULL AFTER `parent1_veggie`'),
        'pujapasses.parent2_lname' => addColumnIfMissing($con, 'pujapasses', 'parent2_lname', 'varchar(100) DEFAULT NULL AFTER `parent2_fname`'),
        'pujapasses.parent2_veggie' => addColumnIfMissing($con, 'pujapasses', 'parent2_veggie', 'tinyint(1) DEFAULT 0 AFTER `parent2_lname`'),
        'pujapasses.extraparentregistration' => addColumnIfMissing($con, 'pujapasses', 'extraparentregistration', 'varchar(50) DEFAULT NULL AFTER `status`'),
    );
    $columnAdded = addParentPriceColumnIfMissing($con);
    $deleted = deleteOldRowsNotInLatestList($con, array_keys($passes));
    $inserted = 0;
    $updated = 0;
    $summaryRows = '';
    $paidPassColumnRows = '';

    foreach ($paidPassColumnResults as $column => $result) {
        $paidPassColumnRows .= '<tr><td>' . htmlspecialchars($column, ENT_QUOTES) . '</td><td>' . htmlspecialchars($result, ENT_QUOTES) . '</td></tr>';
    }

    foreach ($passes as $pujaname => $prices) {
        foreach ($priceForList as $pricefor) {
            foreach ($priceTypeList as $pricetype) {
                $price = $prices[$pricetype];
                $parentprice = $prices['parentprice'];
                $result = upsertPassPrice($con, $pujaname, $pricefor, $pricetype, $price, $parentprice);
                if ($result === 'inserted') {
                    $inserted++;
                } else {
                    $updated++;
                }
                $summaryRows .= '<tr><td>' . htmlspecialchars($pujaname, ENT_QUOTES) . '</td><td>' . htmlspecialchars($pricefor, ENT_QUOTES) . '</td><td>' . htmlspecialchars($pricetype, ENT_QUOTES) . '</td><td>' . htmlspecialchars($price, ENT_QUOTES) . '</td><td>' . htmlspecialchars($parentprice, ENT_QUOTES) . '</td><td>' . htmlspecialchars($result, ENT_QUOTES) . '</td></tr>';
            }
        }
    }

    renderPage(
        'Sync Puja Passes Success',
        '<h2 class="ok">SUCCESS</h2>
        <p>Latest Puja Passes prices synced.</p>
        <p>Paid passes parent save columns checked:</p>
        <table><thead><tr><th>Column</th><th>Status</th></tr></thead><tbody>' . $paidPassColumnRows . '</tbody></table>
        <p>Parent price column added: <code>' . ($columnAdded ? 'yes' : 'already existed') . '</code></p>
        <p>Old rows deleted: <code>' . htmlspecialchars((string) $deleted, ENT_QUOTES) . '</code></p>
        <p>Rows inserted: <code>' . htmlspecialchars((string) $inserted, ENT_QUOTES) . '</code></p>
        <p>Rows updated: <code>' . htmlspecialchars((string) $updated, ENT_QUOTES) . '</code></p>
        <table><thead><tr><th>Pass</th><th>Price For</th><th>Type</th><th>Price</th><th>Parent</th><th>Action</th></tr></thead><tbody>' . $summaryRows . '</tbody></table>'
    );
} catch (Throwable $e) {
    http_response_code(500);
    renderPage('DB Script Failed', '<h2 class="err">FAILED</h2><p>' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '</p>');
}
