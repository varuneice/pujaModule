<?php
// Loads DB credentials and APP_URL/APP_PATH from env.php
require_once __DIR__ . '/application/config/db.php';

if (!defined('INSTALL_URL')) {
    define('INSTALL_URL', $ENV_APP_URL ?? 'https://durgabari-eng3h2fghvcybree.southcentralus-01.azurewebsites.net/HDBS_Puja_Payments/');
}

// Connect to database
try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $con = mysqli_init();
    $is_remote = ($DB_HOST !== 'localhost' && $DB_HOST !== '127.0.0.1');
    if ($is_remote) {
        $ca_paths = [
            'C:\\xampp82\\apache\\bin\\curl-ca-bundle.crt',
            '/etc/ssl/certs/ca-certificates.crt',
            '/etc/pki/tls/certs/ca-bundle.crt',
            '/etc/ssl/ca-bundle.pem',
        ];
        foreach ($ca_paths as $ca) {
            if (file_exists($ca)) {
                $con->ssl_set(null, null, $ca, null, null);
                break;
            }
        }
        $con->real_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, 3306, null, MYSQLI_CLIENT_SSL);
    } else {
        $con->real_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    }
    mysqli_set_charset($con, 'utf8mb4');
    // Azure MySQL enforces ONLY_FULL_GROUP_BY; remove it for this session
    $con->query("SET SESSION sql_mode = REPLACE(@@SESSION.sql_mode, 'ONLY_FULL_GROUP_BY', '')");
} catch (\mysqli_sql_exception $e) {
    die("Connection failed: " . $e->getMessage());
}
