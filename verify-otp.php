<?php
header('Content-Type: application/json');

ini_set('display_errors', '0');
error_reporting(E_ALL);

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
        if (!headers_sent()) {
            header('Content-Type: application/json');
            http_response_code(500);
        }
        echo json_encode([
            'success' => false,
            'message' => 'OTP verification service error. Please contact support.',
        ]);
    }
});

if (session_status() === PHP_SESSION_NONE) {
    session_name('TimeSlotBookingCalendarPHP');
    session_start();
}

require_once __DIR__ . '/application/config/env.php';
include __DIR__ . '/config.php';

function jsonOut($success, $message, $extra = []) {
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $extra));
    exit;
}

function normalizeLookupPhone($phone) {
    return preg_replace('/\D/', '', (string)$phone);
}

function findMemberIdByEmailOrPhone($con, $lookup) {
    $lookup = trim((string)$lookup);
    if (strpos($lookup, '@') !== false) {
        $email = strtolower($lookup);
        $stmt = $con->prepare(
            "SELECT Member_id
             FROM memberltdytd
             WHERE (Active IS NULL OR Active = '')
               AND Category <> 'GC'
               AND (FirstSal != 'Late' OR SpouseSal != 'Late')
               AND (LOWER(email) = ? OR LOWER(Email2) = ?)
             LIMIT 2"
        );
        $stmt->bind_param('ss', $email, $email);
    } else {
        $digits = normalizeLookupPhone($lookup);
        if ($digits === '') {
            return '';
        }
        $stmt = $con->prepare(
            "SELECT Member_id
             FROM memberltdytd
             WHERE (Active IS NULL OR Active = '')
               AND Category <> 'GC'
               AND (FirstSal != 'Late' OR SpouseSal != 'Late')
               AND (
                   Member_id = ?
                   OR
                   REPLACE(REPLACE(REPLACE(REPLACE(COALESCE(Tele1, ''), '-', ''), ' ', ''), '(', ''), ')', '') = ?
                   OR REPLACE(REPLACE(REPLACE(REPLACE(COALESCE(Tele2, ''), '-', ''), ' ', ''), '(', ''), ')', '') = ?
                   OR REPLACE(REPLACE(REPLACE(REPLACE(COALESCE(Mob_No, ''), '-', ''), ' ', ''), '(', ''), ')', '') = ?
               )
             LIMIT 2"
        );
        $stmt->bind_param('ssss', $digits, $digits, $digits, $digits);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $members = [];
    while ($row = $result->fetch_assoc()) {
        $members[] = $row;
    }
    $stmt->close();
    return count($members) === 1 ? trim($members[0]['Member_id'] ?? '') : '';
}

$member_id = trim($_POST['member_id'] ?? '');
$lookup = trim($_POST['lookup'] ?? '');
$otp_input = trim($_POST['otp'] ?? '');

if (!$member_id && $lookup) {
    try {
        $member_id = findMemberIdByEmailOrPhone($con, $lookup);
    } catch (Throwable $e) {
        error_log('[verify-otp] Member lookup failed: ' . $e->getMessage());
        jsonOut(false, 'Could not verify member right now. Please try again.');
    }
}

if (!$member_id || !$otp_input) {
    jsonOut(false, 'All fields are required.');
}
if (!preg_match('/^\d{6}$/', $otp_input)) {
    jsonOut(false, 'Invalid OTP format.');
}

try {
    $stmt = $con->prepare(
        "SELECT id, otp, attempts FROM otp_verification
         WHERE member_id = ? AND verified = 0 AND expires_at > NOW()
         ORDER BY created_at DESC LIMIT 1"
    );
    $stmt->bind_param('s', $member_id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();
} catch (Throwable $e) {
    error_log('[verify-otp] OTP lookup failed: ' . $e->getMessage());
    jsonOut(false, 'OTP table is not available. Please contact support.');
}

if (!$row) {
    jsonOut(false, 'OTP expired or not found. Please request a new one.');
}
if ((int)$row['attempts'] >= 5) {
    jsonOut(false, 'Too many failed attempts. Please request a new OTP.');
}

try {
    $stmt = $con->prepare("UPDATE otp_verification SET attempts = attempts + 1 WHERE id = ?");
    $stmt->bind_param('i', $row['id']);
    $stmt->execute();
    $stmt->close();
} catch (Throwable $e) {
    error_log('[verify-otp] Attempt update failed: ' . $e->getMessage());
    jsonOut(false, 'Could not verify OTP right now. Please try again.');
}

if ($row['otp'] !== $otp_input) {
    $used = (int)$row['attempts'] + 1;
    $remaining = max(0, 5 - $used);
    if ($remaining === 0) {
        jsonOut(false, 'Too many failed attempts. Please request a new OTP.');
    }
    jsonOut(false, 'Invalid OTP. ' . $remaining . ' attempt' . ($remaining === 1 ? '' : 's') . ' remaining.');
}

try {
    $stmt = $con->prepare("UPDATE otp_verification SET verified = 1 WHERE id = ?");
    $stmt->bind_param('i', $row['id']);
    $stmt->execute();
    $stmt->close();
} catch (Throwable $e) {
    error_log('[verify-otp] Verify update failed: ' . $e->getMessage());
    jsonOut(false, 'Could not complete OTP verification. Please try again.');
}

$_SESSION['otp_verified_member'] = $member_id;
$_SESSION['otp_verified_at'] = time();
session_write_close();

jsonOut(true, 'Verified successfully.', ['member_id' => $member_id]);
