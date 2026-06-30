<?php

$accessCode = getenv('LOCAL_STRIPE_ACCESS_CODE') ?: '';
$liveSecretKey = getenv('LOCAL_STRIPE_SECRET_KEY') ?: '';
$livePublishableKey = getenv('LOCAL_STRIPE_PUBLISHABLE_KEY') ?: '';
$message = '';
$error = '';

$rootPath = dirname(__DIR__) . DIRECTORY_SEPARATOR;
define('ROOT_PATH', $rootPath);
require_once $rootPath . 'application/config/constants.php';

function e_local_stripe($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (($_POST['access_code'] ?? '') !== $accessCode) {
            throw new Exception('Wrong access code');
        }

        $secret = trim($_POST['secret_key'] ?? $liveSecretKey);
        $publishable = trim($_POST['publishable_key'] ?? $livePublishableKey);

        if ($accessCode === '') {
            throw new Exception('LOCAL_STRIPE_ACCESS_CODE is not configured');
        }
        if ($secret === '' || $publishable === '') {
            throw new Exception('Stripe keys are required');
        }
        if (strpos($secret, 'sk_live_') !== 0) {
            throw new Exception('Secret key must start with sk_live_');
        }
        if (strpos($publishable, 'pk_live_') !== 0) {
            throw new Exception('Publishable key must start with pk_live_');
        }

        $pdo = gz_pdo_connect(DEFAULT_HOST, DEFAULT_USER, DEFAULT_PASS, DEFAULT_DB);

        $stmt = $pdo->prepare("UPDATE pujapaymetstripeoptions SET value = ? WHERE `key` = ?");
        $stmt->execute([$secret, 'stripe_api_key']);
        $stmt->execute([$publishable, 'stripe_publish_key']);
        $stmt->execute(['1|2::1', 'stripe_allow']);

        $message = 'Done. Local Stripe live keys updated.';
    } catch (Throwable $ex) {
        $error = $ex->getMessage();
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Set Local Stripe Live</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 620px; margin: 40px auto; }
        input { display: block; width: 100%; padding: 10px; margin: 8px 0 16px; box-sizing: border-box; }
        button { padding: 10px 18px; }
        .ok { background: #e9f7ef; padding: 12px; margin-bottom: 16px; }
        .err { background: #fdecea; padding: 12px; margin-bottom: 16px; }
    </style>
</head>
<body>
    <h2>Set Local Stripe Live Keys</h2>

    <?php if ($message): ?><div class="ok"><?php echo e_local_stripe($message); ?></div><?php endif; ?>
    <?php if ($error): ?><div class="err"><?php echo e_local_stripe($error); ?></div><?php endif; ?>

    <form method="post">
        <label>Access Code</label>
        <input type="password" name="access_code" value="">

        <label>Secret Key</label>
        <input type="password" name="secret_key" value="">

        <label>Publishable Key</label>
        <input type="password" name="publishable_key" value="">

        <button type="submit">Update Local DB</button>
    </form>

    <p>Set LOCAL_STRIPE_ACCESS_CODE, or provide the keys through this temporary form.</p>
    <p>Delete this file after use.</p>
</body>
</html>
