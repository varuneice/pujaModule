<?php

require_once(ROOT_PATH . 'application/config/functions.inc.php');

// ============================================================
// env.php is the SINGLE SOURCE OF TRUTH for all DB credentials
// and filesystem/URL paths. It is loaded here unconditionally
// so every constant below is always derived from it.
// DO NOT hardcode credentials or paths anywhere else.
// ============================================================
require_once __DIR__ . '/env.php';

$stop = false;
if (isset($_GET['controller']) && $_GET['controller'] == 'Installer') {
    $stop = true;
    if (isset($_GET['install'])) {
        switch ($_GET['install']) {
            case 1:
                $stop = true;
                break;
            default:
                $stop = false;
                break;
        }
    }
}

if (!$stop) {
    // DB credentials come directly from env.php (loaded above).
    define("DEFAULT_HOST",   $ENV_DB_HOST);
    define("DEFAULT_USER",   $ENV_DB_USER);
    define("DEFAULT_PASS",   $ENV_DB_PASS);
    define("DEFAULT_DB",     $ENV_DB_NAME);
    define("DEFAULT_PREFIX", "");

    if (preg_match('/\[hostname\]/', DEFAULT_HOST) || preg_match('/\[username\]/', DEFAULT_USER)) {
        Util::redirect("index.php?controller=Installer&action=step0&install=1");
    }
}

// Paths also come from env.php — always available because env.php is loaded above.
if (!defined("INSTALL_PATH")) {
    define("INSTALL_PATH", $ENV_APP_PATH);
}
if (!defined("INSTALL_URL")) {
    define("INSTALL_URL", $ENV_APP_URL);
}
if (!defined("INSTALL_FOLDER")) {
    define("INSTALL_FOLDER", "/HDBS_Puja_Payments/");
}

if (!defined("APP_PATH")) {
    define("APP_PATH", ROOT_PATH . "application/");
}
if (!defined("CORE_PATH")) {
    define("CORE_PATH", ROOT_PATH . "core/");
}
if (!defined("LIBS_PATH")) {
    define("LIBS_PATH", "core/libs/");
}
if (!defined("FRAMEWORK_PATH")) {
    define("FRAMEWORK_PATH", CORE_PATH . "framework/");
}
if (!defined("CONFIG_PATH")) {
    define("CONFIG_PATH", APP_PATH . "config/");
}
if (!defined("CONTROLLERS_PATH")) {
    define("CONTROLLERS_PATH", APP_PATH . "controllers/");
}
if (!defined("COMPONENTS_PATH")) {
    define("COMPONENTS_PATH", APP_PATH . "controllers/components/");
}
if (!defined("MODELS_PATH")) {
    define("MODELS_PATH", APP_PATH . "models/");
}
if (!defined("VIEWS_PATH")) {
    define("VIEWS_PATH", APP_PATH . "views/");
}
if (!defined("WEB_PATH")) {
    define("WEB_PATH", APP_PATH . "web/");
}
if (!defined("CSS_PATH")) {
    define("CSS_PATH", "application/web/css/");
}
if (!defined("IMG_PATH")) {
    define("IMG_PATH", "application/web/img/");
}
if (!defined("JS_PATH")) {
    define("JS_PATH", "application/web/js/");
}
if (!defined("UPLOAD_PATH")) {
    define("UPLOAD_PATH", "application/web/upload/");
}

// Mail / SMS enabled flags — sourced from env.php
if (!defined("MAIL_ENABLED")) define("MAIL_ENABLED", $ENV_MAIL_ENABLED);
if (!defined("SMS_ENABLED"))  define("SMS_ENABLED",  $ENV_SMS_ENABLED);

// SMTP credentials — sourced from env.php
if (!defined("SMTP_HOST")) define("SMTP_HOST", $ENV_SMTP_HOST);
if (!defined("SMTP_PORT")) define("SMTP_PORT", $ENV_SMTP_PORT);
if (!defined("SMTP_USER")) define("SMTP_USER", $ENV_SMTP_USER);
if (!defined("SMTP_PASS")) define("SMTP_PASS", $ENV_SMTP_PASS);
if (!defined("SMTP_FROM")) define("SMTP_FROM", $ENV_SMTP_FROM);

// Twilio credentials — sourced from env.php
if (!defined("TWILIO_SID"))   define("TWILIO_SID",   $ENV_TWILIO_SID);
if (!defined("TWILIO_TOKEN")) define("TWILIO_TOKEN", $ENV_TWILIO_TOKEN);
if (!defined("TWILIO_FROM"))  define("TWILIO_FROM",  $ENV_TWILIO_FROM);
?>
