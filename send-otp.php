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
            'message' => 'OTP service error. Please contact support.',
        ]);
    }
});

if (session_status() === PHP_SESSION_NONE) {
    session_name('TimeSlotBookingCalendarPHP');
    session_start();
}

require_once __DIR__ . '/application/config/env.php';
include __DIR__ . '/config.php';

use PHPMailer\PHPMailer\PHPMailer;

function jsonOut($success, $message, $extra = []) {
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $extra));
    exit;
}

function maskEmail($email) {
    $parts = explode('@', $email);
    if (count($parts) !== 2) {
        return $email;
    }
    return substr($parts[0], 0, 2) . str_repeat('*', max(2, strlen($parts[0]) - 2)) . '@' . $parts[1];
}

function maskPhone($phone) {
    $digits = preg_replace('/\D/', '', $phone);
    return '***-***-' . substr($digits, -4);
}

function otpSmsLog($message) {
    $line = '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
    @file_put_contents(__DIR__ . '/otp_sms.log', $line, FILE_APPEND | LOCK_EX);
}

function normalizeLookupPhone($phone) {
    return preg_replace('/\D/', '', (string)$phone);
}

function normalizeSmsPhone($phone) {
    $digits = normalizeLookupPhone($phone);
    if (strlen($digits) === 10) {
        return '+1' . $digits;
    }
    if (strlen($digits) === 11 && substr($digits, 0, 1) === '1') {
        return '+' . $digits;
    }
    if (strlen($digits) >= 8 && strlen($digits) <= 15) {
        return '+' . $digits;
    }
    return '';
}

function findMemberByEmailOrPhone($con, $lookup) {
    $lookup = trim((string)$lookup);
    if (strpos($lookup, '@') !== false) {
        $email = strtolower($lookup);
        $stmt = $con->prepare(
            "SELECT Member_id, email, Email2, Tele1, Tele2, Mob_No
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
            return [];
        }
        $stmt = $con->prepare(
            "SELECT Member_id, email, Email2, Tele1, Tele2, Mob_No
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
    return $members;
}

$lookup = trim($_POST['lookup'] ?? '');

if (!$lookup) {
    jsonOut(false, 'Please enter your email, phone number, or member ID.');
}

try {
    $members = findMemberByEmailOrPhone($con, $lookup);
} catch (Throwable $e) {
    error_log('[send-otp] Member lookup failed: ' . $e->getMessage());
    jsonOut(false, 'Could not verify member right now. Please try again.');
}

if (count($members) === 0) {
    jsonOut(false, 'No active member found with this email or phone number.');
}
if (count($members) > 1) {
    jsonOut(false, 'Multiple active members found with this email or phone number. Please contact the administrator.');
}

$member = $members[0];
$member_id = $member['Member_id'];
$isEmailLookup = (strpos($lookup, '@') !== false);
$lookupDigits = normalizeLookupPhone($lookup);
$emailOnFile = trim(($member['email'] ?? '') ?: ($member['Email2'] ?? ''));
$phoneOnFile = trim(($member['Tele1'] ?? '') ?: (($member['Tele2'] ?? '') ?: ($member['Mob_No'] ?? '')));
$phoneMatchesLookup = false;
foreach (['Tele1', 'Tele2', 'Mob_No'] as $phoneField) {
    if ($lookupDigits !== '' && normalizeLookupPhone($member[$phoneField] ?? '') === $lookupDigits) {
        $phoneMatchesLookup = true;
        break;
    }
}

if ($isEmailLookup) {
    $method = 'email';
    $email = $lookup;
    $phone = $phoneOnFile;
} elseif ($phoneMatchesLookup) {
    $method = 'sms';
    $email = $emailOnFile;
    $phone = $lookup;
} else {
    $email = $emailOnFile;
    if ($email !== '') {
        $method = 'email';
        $phone = $phoneOnFile;
    } else {
        $method = 'sms';
        $phone = $phoneOnFile;
    }
}

if ($method === 'email') {
    if (!$email) {
        jsonOut(false, 'No email address is on file for this member.');
    }
    $masked = maskEmail($email);
} else {
    if (!$phone) {
        jsonOut(false, 'No phone number is on file for this member.');
    }
    if (!normalizeSmsPhone($phone)) {
        otpSmsLog('FAILED member_id=' . $member_id . ' reason=invalid phone raw_phone=' . $phone);
        jsonOut(false, 'The phone number on file is invalid. Please contact the administrator.');
    }
    $masked = maskPhone($phone);
}

try {
    $stmt = $con->prepare(
        "SELECT COUNT(*) AS cnt FROM otp_verification
         WHERE member_id = ? AND created_at > DATE_SUB(NOW(), INTERVAL 5 MINUTE)"
    );
    $stmt->bind_param('s', $member_id);
    $stmt->execute();
    $rate = $stmt->get_result()->fetch_assoc();
    $stmt->close();
} catch (Throwable $e) {
    error_log('[send-otp] Rate lookup failed: ' . $e->getMessage());
    jsonOut(false, 'OTP table is not available. Please contact support.');
}

if ((int)($rate['cnt'] ?? 0) >= 3) {
    jsonOut(false, 'Too many requests. Please wait 5 minutes and try again.');
}

$otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

try {
    $stmt = $con->prepare(
        "INSERT INTO otp_verification (member_id, otp, method, expires_at, attempts, verified)
         VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL 5 MINUTE), 0, 0)"
    );
    $stmt->bind_param('sss', $member_id, $otp, $method);
    $stmt->execute();
    $stmt->close();
} catch (Throwable $e) {
    error_log('[send-otp] Insert failed: ' . $e->getMessage());
    jsonOut(false, 'Could not create OTP. Please contact support.');
}

if ($method === 'email') {
    $memberOtpMailEnabled = isset($ENV_MEMBER_OTP_MAIL_ENABLED) ? $ENV_MEMBER_OTP_MAIL_ENABLED : $ENV_MAIL_ENABLED;
    if (!empty($memberOtpMailEnabled)) {
        $autoload = __DIR__ . '/vendor/autoload.php';
        if (!class_exists(PHPMailer::class) && file_exists($autoload)) {
            require_once $autoload;
        }
        if (!class_exists(PHPMailer::class)) {
            jsonOut(false, 'Email service is not configured. Please contact support.');
        }
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $ENV_SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = $ENV_SMTP_USER;
            $mail->Password = $ENV_SMTP_PASS;
            $mail->SMTPSecure = 'tls';
            $mail->Port = $ENV_SMTP_PORT;
            $mail->CharSet = 'UTF-8';
            $mail->From = $ENV_SMTP_FROM;
            $mail->FromName = 'Houston Durga Bari Society';
            $mail->addAddress($email);
            $mail->Subject = 'Your OTP for Member Verification';
            $mail->isHTML(true);
            $mail->Body = '<div style="font-family:Arial,sans-serif;max-width:480px;margin:0 auto;">'
                . '<div style="background:#357ca5;padding:16px;text-align:center;"><h2 style="color:#fff;margin:0;">Houston Durga Bari Society</h2></div>'
                . '<div style="padding:24px;background:#f9f9f9;"><p>Your OTP for member verification is:</p>'
                . '<div style="font-size:36px;font-weight:bold;letter-spacing:10px;text-align:center;color:#357ca5;padding:16px 0;">' . $otp . '</div>'
                . '<p style="font-size:13px;color:#888;">This OTP is valid for <strong>5 minutes</strong>.</p></div></div>';
            $mail->send();
        } catch (Throwable $e) {
            error_log('[send-otp] Email failed: ' . $e->getMessage());
            jsonOut(false, 'Failed to send OTP email. Please try again.');
        }
    } else {
        error_log('[send-otp TEST] OTP for member ' . $member_id . ' = ' . $otp);
    }
} else {
    $memberOtpSmsEnabled = isset($ENV_MEMBER_OTP_SMS_ENABLED) ? $ENV_MEMBER_OTP_SMS_ENABLED : $ENV_SMS_ENABLED;
    otpSmsLog('START member_id=' . $member_id . ' lookup=' . $lookup . ' raw_phone=' . $phone . ' masked=' . $masked . ' sms_enabled=' . (!empty($memberOtpSmsEnabled) ? 'true' : 'false') . ' twilio_from=' . ($ENV_TWILIO_FROM ?? ''));
    if (!empty($memberOtpSmsEnabled)) {
        $autoload = __DIR__ . '/application/controllers/Twillio/vendor/autoload.php';
        if (!class_exists('\Twilio\Rest\Client') && file_exists($autoload)) {
            require_once $autoload;
        }
        if (!class_exists('\Twilio\Rest\Client')) {
            otpSmsLog('FAILED member_id=' . $member_id . ' reason=Twilio class not found');
            jsonOut(false, 'SMS service is not configured. Please use email OTP.');
        }
        $to = normalizeSmsPhone($phone);
        otpSmsLog('ATTEMPT member_id=' . $member_id . ' to=' . $to);
        try {
            $client = new \Twilio\Rest\Client($ENV_TWILIO_SID, $ENV_TWILIO_TOKEN);
            $message = $client->messages->create($to, [
                'from' => $ENV_TWILIO_FROM,
                'body' => 'Houston Durga Bari Society: Your OTP is ' . $otp . '. Valid for 5 minutes.'
            ]);
            $sid = is_object($message) && isset($message->sid) ? $message->sid : 'unknown';
            otpSmsLog('SUCCESS member_id=' . $member_id . ' to=' . $to . ' sid=' . $sid);
        } catch (\Exception $e) {
            otpSmsLog('FAILED member_id=' . $member_id . ' to=' . $to . ' error=' . $e->getMessage());
            error_log('[send-otp] SMS failed: ' . $e->getMessage());
            jsonOut(false, 'Failed to send OTP SMS. Please try again.');
        }
    } else {
        otpSmsLog('SUPPRESSED member_id=' . $member_id . ' reason=ENV_SMS_ENABLED false');
        error_log('[send-otp TEST] OTP for member ' . $member_id . ' = ' . $otp);
    }
}

jsonOut(true, 'OTP sent successfully.', [
    'member_id' => $member_id,
    'masked' => $masked,
]);
