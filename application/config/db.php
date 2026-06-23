<?php
// ============================================================
// db.php — compatibility shim.
// All DB credentials now come directly from env.php.
// constants.php loads env.php at the top, so DEFAULT_HOST etc.
// are always set from env.php before any model is instantiated.
//
// This file exists only for legacy require_once calls.
// Edit application/config/env.php to change any DB credential or path.
// ============================================================

$_env_file = __DIR__ . '/env.php';
if (!file_exists($_env_file)) {
    die('Missing config: application/config/env.php not found. Create it from env.php and fill in your values.');
}
require_once $_env_file;

// Expose as $DB_* for any code that reads these variables directly.
$DB_HOST = $ENV_DB_HOST;
$DB_NAME = $ENV_DB_NAME;
$DB_USER = $ENV_DB_USER;
$DB_PASS = $ENV_DB_PASS;
