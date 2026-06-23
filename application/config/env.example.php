<?php

// Copy this file to application/config/env.php and fill in real values.
// Never commit application/config/env.php.

$ENV_MAIL_ENABLED = false;
$ENV_SMS_ENABLED = false;
$ENV_MEMBER_OTP_MAIL_ENABLED = false;
$ENV_MEMBER_OTP_SMS_ENABLED = false;

$ENV_DB_HOST = 'localhost';
$ENV_DB_NAME = 'your_database_name';
$ENV_DB_USER = 'your_database_user';
$ENV_DB_PASS = 'your_database_password';

$ENV_APP_URL = 'http://localhost/HDBS_Puja_Payments/';
$ENV_APP_PATH = 'C:/laragon/www/HDBS_Puja_Payments/';

$ENV_MAIL_PROVIDER = 'gmail';

$_smtp = [
    'gmail' => [
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'user' => 'your-email@example.com',
        'pass' => 'your-app-password',
        'from' => 'your-email@example.com',
    ],
    'sendgrid' => [
        'host' => 'smtp.sendgrid.net',
        'port' => 587,
        'user' => 'apikey',
        'pass' => 'your-sendgrid-api-key',
        'from' => 'your-email@example.com',
    ],
];

$ENV_SMTP_HOST = $_smtp[$ENV_MAIL_PROVIDER]['host'];
$ENV_SMTP_PORT = $_smtp[$ENV_MAIL_PROVIDER]['port'];
$ENV_SMTP_USER = $_smtp[$ENV_MAIL_PROVIDER]['user'];
$ENV_SMTP_PASS = $_smtp[$ENV_MAIL_PROVIDER]['pass'];
$ENV_SMTP_FROM = $_smtp[$ENV_MAIL_PROVIDER]['from'];

$ENV_TWILIO_SID = 'your-twilio-sid';
$ENV_TWILIO_TOKEN = 'your-twilio-token';
$ENV_TWILIO_FROM = '+10000000000';
