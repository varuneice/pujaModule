<?php
declare(strict_types=1);

header('Content-Type: text/plain; charset=utf-8');

/*
 * One-time maintenance script.
 * Upload, run with mode=count first, run delete/truncate only with confirm, then remove this file.
 */

const CLEAR_PUJA_REGISTRATION_TOKEN = 'clear-puja-registration-2026-9d7f2b4c';
const TARGET_TABLE = 'pujaregistration';
const DELETE_CONFIRM_TEXT = 'DELETE_PUJAREGISTRATION';
const TRUNCATE_CONFIRM_TEXT = 'TRUNCATE_PUJAREGISTRATION';

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', __DIR__ . '/');
}

require_once ROOT_PATH . 'application/config/constants.php';

function fail_with_message(string $message, int $statusCode = 400): void
{
    http_response_code($statusCode);
    echo $message . PHP_EOL;
    exit;
}

function connect_database(): PDO
{
    if (!defined('DEFAULT_HOST') || !defined('DEFAULT_USER') || !defined('DEFAULT_DB')) {
        fail_with_message('Database constants are not loaded.', 500);
    }

    $dsn = 'mysql:host=' . DEFAULT_HOST . ';dbname=' . DEFAULT_DB . ';charset=utf8mb4';
    return new PDO($dsn, DEFAULT_USER, DEFAULT_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
}

function get_table_count(PDO $pdo): int
{
    return (int) $pdo->query('SELECT COUNT(*) FROM `' . TARGET_TABLE . '`')->fetchColumn();
}

function backup_table_to_csv(PDO $pdo): string
{
    $backupName = 'backup_' . TARGET_TABLE . '_' . date('Ymd_His') . '.csv';
    $backupPath = __DIR__ . '/' . $backupName;

    $handle = fopen($backupPath, 'wb');
    if ($handle === false) {
        fail_with_message('Could not create backup file: ' . $backupName, 500);
    }

    $stmt = $pdo->query('SELECT * FROM `' . TARGET_TABLE . '`');
    $wroteHeader = false;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (!$wroteHeader) {
            fputcsv($handle, array_keys($row));
            $wroteHeader = true;
        }
        fputcsv($handle, $row);
    }

    if (!$wroteHeader) {
        fputcsv($handle, ['empty_table']);
    }

    fclose($handle);
    return $backupName;
}

$token = $_GET['token'] ?? '';
if (!hash_equals(CLEAR_PUJA_REGISTRATION_TOKEN, (string) $token)) {
    fail_with_message('Invalid token.', 403);
}

$mode = strtolower((string) ($_GET['mode'] ?? 'count'));

try {
    $pdo = connect_database();
    $beforeCount = get_table_count($pdo);

    if ($mode === 'count') {
        echo 'Table: ' . TARGET_TABLE . PHP_EOL;
        echo 'Current rows: ' . $beforeCount . PHP_EOL;
        echo 'To delete all rows, call this script with:' . PHP_EOL;
        echo 'mode=delete&confirm=' . DELETE_CONFIRM_TEXT . PHP_EOL;
        echo 'To truncate the table, call this script with:' . PHP_EOL;
        echo 'mode=truncate&confirm=' . TRUNCATE_CONFIRM_TEXT . PHP_EOL;
        exit;
    }

    if (!in_array($mode, ['delete', 'truncate'], true)) {
        fail_with_message('Invalid mode. Use mode=count, mode=delete, or mode=truncate.');
    }

    $confirm = $_GET['confirm'] ?? '';
    if ($mode === 'delete' && $confirm !== DELETE_CONFIRM_TEXT) {
        fail_with_message('Delete not confirmed. Add confirm=' . DELETE_CONFIRM_TEXT);
    }
    if ($mode === 'truncate' && $confirm !== TRUNCATE_CONFIRM_TEXT) {
        fail_with_message('Truncate not confirmed. Add confirm=' . TRUNCATE_CONFIRM_TEXT);
    }

    $backupName = backup_table_to_csv($pdo);

    $pdo->beginTransaction();
    if ($mode === 'truncate') {
        $deletedRows = $beforeCount;
        $pdo->exec('TRUNCATE TABLE `' . TARGET_TABLE . '`');
    } else {
        $deletedRows = $pdo->exec('DELETE FROM `' . TARGET_TABLE . '`');
    }
    $pdo->commit();

    if ($mode !== 'truncate') {
        try {
            $pdo->exec('ALTER TABLE `' . TARGET_TABLE . '` AUTO_INCREMENT = 1');
        } catch (Throwable $ignored) {
            // Some MySQL configurations may not allow this. The data delete already succeeded.
        }
    }

    $afterCount = get_table_count($pdo);

    echo 'Table: ' . TARGET_TABLE . PHP_EOL;
    echo 'Backup file: ' . $backupName . PHP_EOL;
    echo 'Mode: ' . $mode . PHP_EOL;
    echo 'Rows before: ' . $beforeCount . PHP_EOL;
    echo 'Rows deleted: ' . (int) $deletedRows . PHP_EOL;
    echo 'Rows after: ' . $afterCount . PHP_EOL;
    echo 'Done. Remove this script from Azure now.' . PHP_EOL;
} catch (Throwable $e) {
    if (isset($pdo) && $pdo instanceof PDO && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    fail_with_message('Error: ' . $e->getMessage(), 500);
}
