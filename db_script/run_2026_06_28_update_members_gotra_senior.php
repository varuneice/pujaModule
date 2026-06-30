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

function requireColumn(mysqli $con, $table, $column)
{
    if (!columnExists($con, $table, $column)) {
        throw new RuntimeException('Missing required column `' . $table . '`.`' . $column . '`.');
    }
}

function requireVisibleColumn(mysqli $con, $table, $column)
{
    $result = $con->query('SHOW COLUMNS FROM `' . str_replace('`', '``', $table) . '` LIKE "' . $con->real_escape_string($column) . '"');
    $exists = $result && $result->num_rows > 0;
    if ($result) {
        $result->free();
    }

    if (!$exists) {
        throw new RuntimeException('Missing required column `' . $table . '`.`' . $column . '`.');
    }
}

function scalar(mysqli $con, $sql)
{
    $result = $con->query($sql);
    $row = $result->fetch_row();
    $result->free();
    return (int) ($row[0] ?? 0);
}

function loadSourceSqlIntoTempTable(mysqli $con, $sqlPath)
{
    if (!file_exists($sqlPath)) {
        throw new RuntimeException('Source SQL file not found: ' . $sqlPath);
    }

    $sql = file_get_contents($sqlPath);
    if ($sql === false || trim($sql) === '') {
        throw new RuntimeException('Source SQL file is empty or unreadable.');
    }

    $sourceTable = 'Member_Gotra_Senior_2025';
    $tempTable = 'tmp_member_gotra_senior_2025';

    $sql = preg_replace('/CREATE\s+TABLE\s+`' . preg_quote($sourceTable, '/') . '`/i', 'CREATE TEMPORARY TABLE `' . $tempTable . '`', $sql, 1);
    $sql = str_replace('`' . $sourceTable . '`', '`' . $tempTable . '`', $sql);
    $sql = preg_replace('/START\s+TRANSACTION\s*;/i', '', $sql);
    $sql = preg_replace('/COMMIT\s*;/i', '', $sql);

    $con->query('DROP TEMPORARY TABLE IF EXISTS `' . $tempTable . '`');

    if (!$con->multi_query($sql)) {
        throw new RuntimeException($con->error);
    }

    do {
        if ($result = $con->store_result()) {
            $result->free();
        }
    } while ($con->more_results() && $con->next_result());

    if ($con->errno) {
        throw new RuntimeException($con->error);
    }

    requireVisibleColumn($con, $tempTable, 'Member_id');
    requireVisibleColumn($con, $tempTable, 'Gotra');
    requireVisibleColumn($con, $tempTable, 'Senior');

    return $tempTable;
}

if (!isset($con) || !($con instanceof mysqli)) {
    http_response_code(500);
    renderPage('Member Gotra/Senior Update Failed', '<h2 class="err">FAILED</h2><p>Database connection not available.</p>');
    exit;
}

try {
    requireColumn($con, 'members', 'Member_id');
    requireColumn($con, 'members', 'Gotra');
    requireColumn($con, 'members', 'Senior');

    $sqlPath = __DIR__ . '/Member_Gotra_Senior_2025.sql';
    $tempTable = loadSourceSqlIntoTempTable($con, $sqlPath);

    $sourceRows = scalar($con, 'SELECT COUNT(*) FROM `' . $tempTable . '`');
    $sourceRowsWithMemberId = scalar($con, 'SELECT COUNT(*) FROM `' . $tempTable . '` WHERE `Member_id` IS NOT NULL');
    $matchedMembers = scalar($con, 'SELECT COUNT(*) FROM `members` m INNER JOIN `' . $tempTable . '` s ON m.`Member_id` = s.`Member_id`');
    $gotraCandidates = scalar($con, 'SELECT COUNT(*) FROM `members` m INNER JOIN `' . $tempTable . '` s ON m.`Member_id` = s.`Member_id` WHERE s.`Gotra` IS NOT NULL AND TRIM(s.`Gotra`) <> ""');
    $seniorCandidates = scalar($con, 'SELECT COUNT(*) FROM `members` m INNER JOIN `' . $tempTable . '` s ON m.`Member_id` = s.`Member_id` WHERE s.`Senior` IS NOT NULL AND TRIM(s.`Senior`) <> ""');

    if (($_GET['run'] ?? '') !== '1') {
        renderPage(
            'Update Members Gotra/Senior',
            '<h2>Update Members Gotra/Senior</h2>
            <p>This will read <code>db_script/Member_Gotra_Senior_2025.sql</code> and update <code>members</code> by <code>Member_id</code>.</p>
            <p>Blank or NULL source values will not overwrite existing member values.</p>
            <table><tbody>
                <tr><th>Source rows</th><td>' . htmlspecialchars((string) $sourceRows, ENT_QUOTES) . '</td></tr>
                <tr><th>Source rows with Member_id</th><td>' . htmlspecialchars((string) $sourceRowsWithMemberId, ENT_QUOTES) . '</td></tr>
                <tr><th>Matching members</th><td>' . htmlspecialchars((string) $matchedMembers, ENT_QUOTES) . '</td></tr>
                <tr><th>Gotra updates available</th><td>' . htmlspecialchars((string) $gotraCandidates, ENT_QUOTES) . '</td></tr>
                <tr><th>Senior updates available</th><td>' . htmlspecialchars((string) $seniorCandidates, ENT_QUOTES) . '</td></tr>
            </tbody></table>
            <p><a class="btn" href="?run=1">Run Member Update</a></p>'
        );
        exit;
    }

    $con->begin_transaction();
    $updateSql = 'UPDATE `members` m
        INNER JOIN `' . $tempTable . '` s ON m.`Member_id` = s.`Member_id`
        SET
            m.`Gotra` = CASE
                WHEN s.`Gotra` IS NOT NULL AND TRIM(s.`Gotra`) <> "" THEN s.`Gotra`
                ELSE m.`Gotra`
            END,
            m.`Senior` = CASE
                WHEN s.`Senior` IS NOT NULL AND TRIM(s.`Senior`) <> "" THEN s.`Senior`
                ELSE m.`Senior`
            END
        WHERE
            (s.`Gotra` IS NOT NULL AND TRIM(s.`Gotra`) <> "")
            OR (s.`Senior` IS NOT NULL AND TRIM(s.`Senior`) <> "")';

    if (!$con->query($updateSql)) {
        throw new RuntimeException($con->error);
    }
    $affectedRows = max(0, $con->affected_rows);
    $con->commit();

    renderPage(
        'Member Gotra/Senior Update Success',
        '<h2 class="ok">SUCCESS</h2>
        <p><code>members.Gotra</code> and <code>members.Senior</code> were updated from <code>Member_Gotra_Senior_2025.sql</code>.</p>
        <table><tbody>
            <tr><th>Source rows</th><td>' . htmlspecialchars((string) $sourceRows, ENT_QUOTES) . '</td></tr>
            <tr><th>Matching members</th><td>' . htmlspecialchars((string) $matchedMembers, ENT_QUOTES) . '</td></tr>
            <tr><th>Gotra source values</th><td>' . htmlspecialchars((string) $gotraCandidates, ENT_QUOTES) . '</td></tr>
            <tr><th>Senior source values</th><td>' . htmlspecialchars((string) $seniorCandidates, ENT_QUOTES) . '</td></tr>
            <tr><th>Rows changed by MySQL</th><td>' . htmlspecialchars((string) $affectedRows, ENT_QUOTES) . '</td></tr>
        </tbody></table>'
    );
} catch (Throwable $e) {
    if (isset($con) && $con instanceof mysqli) {
        try {
            $con->rollback();
        } catch (Throwable $ignored) {
        }
    }
    http_response_code(500);
    renderPage('Member Gotra/Senior Update Failed', '<h2 class="err">FAILED</h2><p>' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '</p>');
}
