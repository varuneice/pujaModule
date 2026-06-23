# HDBS Payment – Puja Module: Master Remediation Guide
_Generated: 2026-03-16_

---

## Table of Contents

1. [Application Overview](#1-application-overview)
2. [Current State Summary](#2-current-state-summary)
3. [Security Vulnerabilities](#3-security-vulnerabilities)
   - 3.1 [SQL Injection](#31-sql-injection--critical)
   - 3.2 [XSS – Cross-Site Scripting](#32-xss--cross-site-scripting--high)
   - 3.3 [CSRF – Missing Token Protection](#33-csrf--missing-token-protection--high)
   - 3.4 [Exposed Backup Files](#34-exposed-backup-files--high)
   - 3.5 [Hardcoded Credentials in Source Code](#35-hardcoded-credentials-in-source-code--high)
   - 3.6 [CORS Wildcard Header](#36-cors-wildcard-header--high)
   - 3.7 [Error Reporting Misconfiguration](#37-error-reporting-misconfiguration--medium)
   - 3.8 [Weak Password / Token Generation](#38-weak-password--token-generation--medium)
   - 3.9 [No Rate Limiting](#39-no-rate-limiting--medium)
   - 3.10 [File Upload Validation Missing](#310-file-upload-validation-missing--medium)
   - 3.11 [Hardcoded localhost URLs](#311-hardcoded-localhost-urls--medium)
   - 3.12 [Overly Permissive Upload Permissions](#312-overly-permissive-upload-permissions--low)
4. [PHP 7.4 → 8.2 Migration Issues](#4-php-74--82-migration-issues)
   - 4.1 [Fatal Errors – Will Not Boot on PHP 8](#41-fatal-errors--will-not-boot-on-php-8)
   - 4.2 [Third-party Libraries – Must Be Upgraded](#42-third-party-libraries--must-be-upgraded)
   - 4.3 [PHP 8.1 / 8.2 Deprecations](#43-php-81--82-deprecations)
5. [Recommended Order of Work](#5-recommended-order-of-work)
6. [Testing Checklist](#6-testing-checklist)

---

## 1. Application Overview

**HDBS Payment (Puja Module)** is a PHP-based web application managing the full lifecycle of annual Puja festival events for a Hindu/Durgabari/Brahmin Society.

### What It Does
- Puja registration (early, regular, family workflows)
- Online puja payments and sponsorships (Stripe + Authorize.Net)
- Food coupon management and redemption
- Paid parking and passes management
- Badge creation and CSV import
- Ticket management (puja tickets, admin ticketing)
- Magazine subscriptions (PujaMagazine)
- Sankalpa (puja dedication) registration
- Member lookup and donation tracking
- Calendar and time-slot based priest booking (GzFront)
- Statistics and reporting

### Technical Stack

| Layer | Technology | Status |
|---|---|---|
| Language | PHP 7.4.30 | **EOL Nov 2022 — no security patches** |
| Framework | Custom lightweight MVC | Functional but aging |
| Database | MySQL via MySQLi + custom FluentPDO query builder | Mixed — ORM and raw mysqli both used |
| Authentication | Session-based (`$_SESSION['admin_user']`, `$_SESSION['front_user']`) | Works, no CSRF guard |
| Authorization | RBAC — 14+ user types | Consistently applied |
| Email | PHPMailer 5.2.4 | **EOL — PHP 8 incompatible** |
| PDF | mPDF 5.7 | **EOL — PHP 8 incompatible** |
| Payments | Stripe (legacy v2/v3), Authorize.Net (`sdk-php-master/`) | Outdated SDKs |
| SMS | Twilio SDK 6.35.1 | Upgradable |
| Frontend | jQuery 1.9.1, Bootstrap 3 | Outdated |
| Web Server | Apache/XAMPP | — |

### Project Scale
- Controllers: **53+ active** + 7 backup files
- Models: **64 classes** + 10 backup files
- Views: **358 templates** + 20+ backup files
- User Roles: **14+** (Admin, Editor, Volunteer, Events, Parking Admin, Badges Admin, Food Coupon Admin, Education, Registration, Vendor, Viewer, Merchandise Viewer, Merchandise Editor, etc.)

---

## 2. Current State Summary

### Security Score Card

| Category | Status | Detail |
|---|---|---|
| SQL Injection | **FAIL** | Raw `$_GET` interpolated into SQL — public endpoint |
| XSS Protection | **FAIL** | Disabled input filter block in `index.php`; unescaped output throughout |
| CSRF Protection | **FAIL** | No tokens anywhere across all 53+ controllers |
| Credentials | **FAIL** | Production password committed in plaintext comments |
| Error Handling | **FAIL** | Suppressed + displayed simultaneously — contradictory config |
| CORS | **FAIL** | Wildcard `Access-Control-Allow-Origin: *` set globally |
| File Uploads | **FAIL** | No MIME type validation |
| Rate Limiting | **FAIL** | No throttling on login or payment endpoints |
| Authentication | **PASS** | Session-based with role checks consistently applied |

### PHP Compatibility Score Card

| Issue | Severity | Detail |
|---|---|---|
| `mysql_query()` / `mysql_fetch_assoc()` in `Object.class.php` | **FATAL** | Removed in PHP 7.0 — app will not boot |
| `each()` in mPDF 5.7 and PHPMailer 5.2.4 | **FATAL** | Removed in PHP 8.0 |
| `get_magic_quotes_*()` in mPDF and PHPMailer | **FATAL** | Removed in PHP 8.0 |
| PHPMailer 5.2.4 | **FATAL** | Multiple PHP 8 incompatibilities |
| mPDF 5.7 | **FATAL** | Multiple PHP 8 incompatibilities |
| Dynamic property creation across 53+ controllers | **ERROR** | Deprecated in PHP 8.2 |
| `date_default_timezone_set(null)` pattern | **WARNING** | Deprecated in PHP 8.1 |
| `${var}` string interpolation in Stripe helper | **WARNING** | Deprecated in PHP 8.2 |
| `BaseQuery::getIterator()` return type | **WARNING** | Interface incompatibility in PHP 8 |
| `0 == "string"` loose comparisons | **BEHAVIOR CHANGE** | Changed in PHP 8.0 |

---

## 3. Security Vulnerabilities

---

### 3.1 SQL Injection — CRITICAL

**File:** `ajax-db-search.php` — line 14
**Authentication required:** None — this is a public endpoint

**What the code does now:**
```php
$query = "SELECT ... FROM memberltdytd WHERE (
    F_name LIKE '{$_GET['term']}%'
    OR L_Name LIKE '{$_GET['term']}%'
    OR Zip LIKE '{$_GET['term']}%'
    OR Sp_FName LIKE '{$_GET['term']}%'
    OR Sp_LName LIKE '{$_GET['term']}%'
    OR Member_id LIKE '{$_GET['term']}%'
) ...";
$result = mysqli_query($con, $query);
```

The raw `$_GET['term']` value is directly interpolated into the SQL string with no escaping, no parameterization, and no authentication check. Anyone on the internet can send a crafted request to this URL and extract or manipulate the database.

**The fix:**
Convert to a `mysqli` prepared statement with `bind_param`:
```php
$term = $_GET['term'] . '%';
$stmt = $con->prepare("SELECT ... FROM memberltdytd WHERE (
    F_name LIKE ? OR L_Name LIKE ? OR Zip LIKE ?
    OR Sp_FName LIKE ? OR Sp_LName LIKE ? OR Member_id LIKE ?
) AND ...");
$stmt->bind_param('ssssss', $term, $term, $term, $term, $term, $term);
$stmt->execute();
$result = $stmt->get_result();
```

**Also audit:** Run a full grep for `$_GET`, `$_POST`, `$_REQUEST` across all controllers and models to identify any other raw interpolation points.

---

### 3.2 XSS – Cross-Site Scripting — HIGH

**Root cause:** An entire XSS input-sanitization block was commented out in `index.php` (lines 1–7). It was never replaced with output escaping.

**Current state of `index.php`:**
```php
<?php//BEGIN SITELOCK XSS VULNERABILITY FIX
// foreach (array('email','forgo_password','submit','puja_type', ...) as $v) {
//     isset($_REQUEST[$v]) and $_REQUEST[$v] = htmlentities($_REQUEST[$v]);
//     ...
// }
//END SITELOCK XSS VULNERABILITY FIX
ini_set("display_errors", "On");
```

The input sanitization at the entry point is commented out. Output escaping was never added to views as a replacement. User-supplied values from `$_GET` / `$_POST` / database records are echoed directly into HTML across hundreds of view files.

**Files confirmed affected:**
- `application/controllers/Admin.php` — echo in HTML contexts
- `application/controllers/Member.php` — echo in HTML contexts
- `application/controllers/GzFront.php` — `$_POST` values echoed in HTML (payment callback)

**The fix (two steps):**

**Step 1** — Add a global escape helper to `application/config/functions.inc.php`:
```php
function h($val) {
    return htmlspecialchars((string)$val, ENT_QUOTES, 'UTF-8');
}
```

**Step 2** — Audit all 358 view files and wrap every echoed variable:
```php
// UNSAFE — what currently exists
echo "<input value='$value[Member_id]'/>";
echo $row['F_Name'];

// SAFE — after fix
echo "<input value='" . h($value['Member_id']) . "'/>";
echo h($row['F_Name']);
```

**Note:** Do NOT use `htmlspecialchars()` on JSON or CSV output — it will corrupt the data format. Use `print` for those contexts unchanged.

---

### 3.3 CSRF – Missing Token Protection — HIGH

**File:** `core/framework/Controller.class.php`
**Scope:** All 53+ controllers, all POST forms

No CSRF token is generated, stored in session, embedded in forms, or validated anywhere in the application. Any authenticated user can be tricked into submitting any form action by visiting a malicious third-party page.

**The fix (3 changes):**

**Change 1** — Generate token in `core/bootstrap.php` (runs before any controller):
```php
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
```

**Change 2** — Validate in `Controller.class.php` `beforeFilter()`:
```php
function beforeFilter() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $submitted = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'], $submitted)) {
            http_response_code(403);
            exit('Invalid CSRF token.');
        }
    }
}
```

**Change 3** — Add hidden field to every POST form in all view files:
```html
<input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">
```

The `priestModule` has a `tools/add-csrf-tokens.php` automated tool that can insert the hidden input into all view forms — adapt and reuse it for pujaModule's 358 view files.

---

### 3.4 Exposed Backup Files — HIGH

Backup files with old, potentially vulnerable code exist throughout the codebase. They are web-accessible and may expose historical credentials or exploitable logic.

**Controllers to delete:**
- `application/controllers/mailbackup.php`
- `application/controllers/parkingadmin_06Sep2023_bkp.php`
- `application/controllers/PujaMagazine_06Sep2023_bkp.php`
- `application/controllers/PujaMagazineadmin_06Sep2023_bkp.php`
- `application/controllers/PujaPaidparking_06Sep2023_bkp.php`
- `application/controllers/PujaOnlinePayments2_July.php`
- `application/controllers/pujafoodcoupon_HIST_10_OCT_2024.php`

**Models to delete:**
- `application/models/Booking.modelbackup.php`
- `application/models/memberbackup16`
- `application/models/foodcouponprice_old.model.php`
- `application/models/pujafoodcouponold.model.php`
- `application/models/PujaTicketPrice_06Sep2023_bkp.model.php`
- `application/models/pujamagazine_06Sep_2023_bkp.model.php`
- `application/models/paidparking_06Sep2023_bkp.model.php`
- `application/models/pujamagazineprice_06Sep2023_bkp.model.php`
- `application/models/ticket_06Sep2023_bkp.model.php`
- `application/models/ticketeventname_06Sep2023_bkp.model.php`

**Views to delete:**
- `application/views/Badges/createbackup.php`
- `application/views/Badges/editbackup.php`
- `application/views/Badges/edit(26julybackup)`
- `application/views/Calendar/settings/paymentbackup.php`
- `application/views/GzFront/booking_formbackup.php`
- `application/views/GzFront/component/extra_formbackup10july.php`
- `application/views/GzFront/component10julybackup.php`
- `application/views/GzFront/component/booking_formbackup10july.php`
- `application/views/GzFront/component/extra_formbackup.php`
- `application/views/GzFront/gettime_backup29may.php`
- `application/views/Layouts/admin/menu/sidebarbackup.php`
- `application/views/Member/createbackup.php`
- `application/views/Member/editbackup.php`
- `application/views/parkingadmin/component/parking_registration_table_06Sep2023_bkp.php`
- `application/views/parkingadmin/component/search_06Sep2023_bkp.php`
- `application/views/parkingadmin/index_06Sep2023_bkp.php`
- `application/views/parkingadmin/edit_06Sep2023_bkp.php`
- `application/views/parkingadmin/payment_06Sep2023_bkp.php`
- `application/views/PujaMagazine/PujaMagazine_06_Sep2023_bkp.php`
- `application/views/Preview/index7julybackup.php`
- `application/views/Preview/index5julybackup.php`
- `application/views/Preview/indexbackup`

**Steps:**
1. Before deleting, grep for any `require`/`include` that still references these files to confirm they are unused
2. Delete all confirmed-unused files
3. Add `.htaccess` rules blocking direct browser access to `.sql`, `.bak`, `.dump`, `.tar`, `.log` files
4. Add `.htaccess` to `application/config/` denying all HTTP access (SQL migration files there must not be web-accessible)
5. Use Git branches for version history going forward — backup files in a production codebase are an antipattern

---

### 3.5 Hardcoded Credentials in Source Code — HIGH

**Files:**
- `config.php` (lines 9–11) — commented-out block contains production credentials
- `application/config/constants.php` (lines 28–32) — same production credentials commented out

**What is in the source right now:**
```php
// $DB_USER='durgab5_hdbsprod';
// $DB_PASS='GhKiBW1zVyCL';
// $DB_NAME='durgab5_HDBS_PaymentTesting';
```

The password `GhKiBW1zVyCL` for `durgab5_hdbsprod` is committed in plaintext. Anyone with access to the source code (or if the file is ever accidentally exposed) can see the production database password.

**Steps:**
1. **Immediately remove** the commented-out credential blocks from both `config.php` and `constants.php`
2. Move `config.php` **outside the web root** — it should not be reachable via browser under any circumstances
3. Replace hardcoded define values with environment variables:
   ```php
   define("DEFAULT_USER", getenv('DB_USER') ?: 'root');
   define("DEFAULT_PASS", getenv('DB_PASS') ?: '');
   define("DEFAULT_DB",   getenv('DB_NAME') ?: 'durgab5_HDBS_Payment_Prod');
   ```
4. Add `config.php` and any `.env` files to `.gitignore`
5. Set a strong password on the MySQL database user; never use `root` with empty password in production
6. Create a dedicated MySQL user with only the permissions the application needs (not full root access)

---

### 3.6 CORS Wildcard Header — HIGH

**Files:** `ajax-db-search.php` (line 2) and root `.htaccess`

`Access-Control-Allow-Origin: *` is set in two places:
- `ajax-db-search.php` line 2: `header('Access-Control-Allow-Origin: *');`
- Root `.htaccess`: global `Header set Access-Control-Allow-Origin "*"` directive

This allows any website on the internet to make cross-origin AJAX requests to this application and read the responses — including member personal data returned by the search endpoint.

**The fix:**

In `.htaccess`, replace the wildcard with the specific trusted domain:
```apache
# Remove:
Header set Access-Control-Allow-Origin "*"

# Replace with:
Header set Access-Control-Allow-Origin "https://your-production-domain.com"
```

In `ajax-db-search.php`, remove the `header('Access-Control-Allow-Origin: *');` line — the `.htaccess` directive should be the single authoritative location for CORS configuration.

If cross-origin access is not needed at all, remove the header entirely from both locations.

---

### 3.7 Error Reporting Misconfiguration — MEDIUM

**Files:**
- `application/config/config.php` line 3: `error_reporting(0)` — all errors suppressed
- `index.php`: `ini_set("display_errors", "On")` — errors displayed to browser

These two settings contradict each other and create an insecure state. Error details should never be shown to end users in production.

**The fix:**

Remove both of these lines and replace with environment-aware configuration driven by an `APP_ENV` environment variable:

**Development:**
```php
error_reporting(E_ALL);
ini_set('display_errors', '1');
```

**Production:**
```php
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', '/path/outside/webroot/php-errors.log');
```

Also remove the `@` error-suppression operators on `session_name()` and `session_start()` calls in `index.php` — these mask real session errors that should be visible in development.

---

### 3.8 Weak Password / Token Generation — MEDIUM

**File:** `core/framework/Controller.class.php` lines 148–155

The `getRandomPassword()` method uses `srand()` + `rand()` which is a non-cryptographic pseudo-random number generator. Passwords and tokens generated with `rand()` are predictable.

**What the code does now:**
```php
function getRandomPassword($n = 6, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890') {
    srand((double) microtime() * 1000000);
    $m = strlen($chars);
    $randPassword = "";
    while ($n--) {
        $randPassword .= substr($chars, rand() % $m, 1);
    }
    return $randPassword;
}
```

**The fix:**
```php
function getRandomPassword($n = 6, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890') {
    $m = strlen($chars) - 1;
    $randPassword = "";
    while ($n--) {
        $randPassword .= $chars[random_int(0, $m)];
    }
    return $randPassword;
}
```

Also audit `Util::random_password()` and `Util::incrementalHash()` in `application/config/functions.inc.php` for any use of `rand()` in security-sensitive contexts and replace with `random_int()` / `random_bytes()`.

---

### 3.9 No Rate Limiting — MEDIUM

**Files:** `application/controllers/Admin.php` (login), `application/controllers/PujaOnlinePayments.php`, `application/controllers/PujaDonations.php`

No rate limiting exists on login or payment submission endpoints. An attacker can brute-force login credentials or flood payment endpoints without any throttle.

**The fix:**

1. Create a `login_attempts` table:
   ```sql
   CREATE TABLE login_attempts (
       id INT AUTO_INCREMENT PRIMARY KEY,
       action VARCHAR(50) NOT NULL,
       identifier VARCHAR(255) NOT NULL,
       attempted_at DATETIME NOT NULL,
       INDEX idx_action_id_time (action, identifier, attempted_at)
   );
   ```

2. Implement a `RateLimit` class in `functions.inc.php` (see priestModule's implementation):
   - `isBlocked($action, $identifier)` — returns true if threshold exceeded within window
   - `record($action, $identifier)` — logs an attempt
   - `clear($action, $identifier)` — clears on successful login
   - Fail open (allow request) if DB is unavailable

3. Apply to login POST in `Admin.php` and payment submission in `PujaOnlinePayments.php`, `Member.php` checkout, and `PujaDonations.php`

---

### 3.10 File Upload Validation Missing — MEDIUM

**File:** `application/controllers/Badges.php` (CSV import path)

Uploaded files are accepted and processed without any server-side MIME type validation. A malicious actor could upload a PHP file disguised as a CSV.

**The fix:**

Add MIME type validation using `finfo` before processing any upload:
```php
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $_FILES['csv_file']['tmp_name']);
finfo_close($finfo);

$allowed = ['text/plain', 'text/csv', 'application/csv'];
if (!in_array($mime, $allowed)) {
    // reject — return error response
}
```

Additional hardening:
- Validate CSV column headers match the expected schema before processing rows
- Sanitize every cell value from the CSV before using in queries
- Generate a random server-side filename — never use the user-supplied original filename
- Store uploaded files outside the web root where possible
- Set a maximum file size limit enforced server-side (not just `php.ini`)

---

### 3.11 Hardcoded localhost URLs — MEDIUM

**File:** `application/config/constants.php` lines 68–76

`INSTALL_URL` and `INSTALL_PATH` are hardcoded to `localhost`. Email templates and other files reference these directly. The application will produce broken links in any non-local environment.

**Current code:**
```php
define("INSTALL_PATH", "C:/xampp/htdocs/HDBS_Payment/pujaModule/");
define("INSTALL_URL",  "http://localhost:8082/HDBS_Payment/pujaModule/");
```

**The fix:**
```php
define("INSTALL_PATH", getenv('APP_PATH') ?: "C:/xampp/htdocs/HDBS_Payment/pujaModule/");
define("INSTALL_URL",  getenv('APP_URL')  ?: "http://localhost:8082/HDBS_Payment/pujaModule/");
```

Then run a grep for `localhost` across all PHP files to find every hardcoded URL in email templates, views, and controllers, and replace each with `INSTALL_URL . '/path'`.

---

### 3.12 Overly Permissive Upload Permissions — LOW

**File:** `application/helpers/uploader/class.upload.php`

The uploader calls `chmod(0777)` on uploaded files, making them world-writable and world-executable on Linux hosts.

**The fix:** Replace `chmod(0777, $file)` with `chmod(0644, $file)` — owner read/write, group and others read only.

---

## 4. PHP 7.4 → 8.2 Migration Issues

The application currently runs **PHP 7.4.30**, which reached end-of-life on November 28, 2022.

### Target Version

| Version | Active Support | Security Support | Recommendation |
|---|---|---|---|
| PHP 8.2 | Ended Dec 2024 | Until Dec 2026 | **Intermediate target** — already running in dev (xampp82) |
| PHP 8.3 | Ended Nov 2025 | Until Nov 2027 | Skip — security-only, no benefit over 8.4 |
| **PHP 8.4** | **Until Nov 2026** | **Until Nov 2028** | **Final target** — current stable, longest support |

**Migration path: PHP 7.4 → 8.2 → 8.4**

The hard work is the 7.4 → 8.x jump (fatal errors, library replacements, deprecations). After that, 8.2 → 8.4 is a small, low-risk step. Since the dev environment is already PHP 8.2 (xampp82), that is the practical first destination. Upgrade to 8.4 before December 2026 when 8.2 security support ends.

**Do not attempt the PHP upgrade until security remediation (Section 3) is complete.** Security fixes come first.

---

### 4.1 Fatal Errors — Will Not Boot on PHP 8

These issues will cause an immediate fatal error. The application will not start until they are resolved.

#### `mysql_*` Functions (Removed in PHP 7.0 — Fatal in PHP 8)

| File | Lines | Issue |
|---|---|---|
| `core/framework/Object.class.php` | 10–11 | `mysql_query()`, `mysql_fetch_assoc()` in `_getNextOrder()` |
| `application/helpers/PHPMailer_5.2.4/examples/test_db_smtp_basic.php` | 35–40 | `MYSQL_CONNECT()`, `mysql_select_db()`, `MYSQL_QUERY()`, `mysql_fetch_array()` |

**Fix for `Object.class.php`:** The `_getNextOrder()` method needs to be rewritten using `mysqli` or the existing PDO query builder. Check if this method is still actually called — it may be unused given the newer query builder exists.

**Fix for PHPMailer example file:** Upgrade to PHPMailer 6.x — the example files are not used in production and the new library will replace the entire `PHPMailer_5.2.4/` directory.

#### `each()` Function (Removed in PHP 8.0)

| File | Issue |
|---|---|
| `application/helpers/MPDF57/mpdf.php` | Multiple `while(list(...) = each(...))` loops |
| `application/helpers/PHPMailer_5.2.4/class.phpmailer.php` | `each()` in while loop (line 2050) |
| `application/helpers/PHPMailer_5.2.4/class.smtp.php` | `@each()` in while loops (lines 544, 573) |

**Fix:** Upgrade the libraries (see Section 4.2). Do not patch `each()` manually inside bundled vendor files — replace the libraries entirely.

#### `get_magic_quotes_*` / `set_magic_quotes_*` (Removed in PHP 8.0)

| File | Issue |
|---|---|
| `application/helpers/MPDF57/compress.php` | Lines 91, 96: `get_magic_quotes_runtime()`, `set_magic_quotes_runtime(0)` |
| `application/helpers/MPDF57/mpdf.php` | Lines 9478, 9480: `ini_get("magic_quotes_runtime")` |
| `application/helpers/PHPMailer_5.2.4/class.phpmailer.php` | Lines 1856–1870: Multiple magic_quotes calls |

**Fix:** Upgrading mPDF and PHPMailer libraries (Section 4.2) resolves all of these automatically.

---

### 4.2 Third-party Libraries — Must Be Upgraded

All four bundled libraries are incompatible with PHP 8 and must be replaced.

#### PHPMailer 5.2.4 → 6.x

**Files using this library:** `application/controllers/App.php` and any controller that sends email (grep for `PHPMailer_5.2.4`).

**Steps:**
1. Add to root `composer.json`: `"phpmailer/phpmailer": "^6.0"` — run `composer install`
2. In each controller that uses PHPMailer, replace:
   ```php
   // OLD
   require_once ROOT_PATH . 'application/helpers/PHPMailer_5.2.4/class.phpmailer.php';
   $mail = new PHPMailer();

   // NEW
   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception as PHPMailerException;
   // (autoloaded via vendor/autoload.php — no require_once needed)
   $mail = new PHPMailer(true);
   ```
3. Fix any `catch (phpmailerException)` → `catch (PHPMailerException)`
4. Add `require_once ROOT_PATH . 'vendor/autoload.php';` to `index.php` (if Composer autoloader not already loaded)
5. Delete the entire `application/helpers/PHPMailer_5.2.4/` directory

#### mPDF 5.7 → 8.x

**Files using this library:** Models in `application/models/` that generate PDF reports; any controller generating badge or invoice PDFs (grep for `MPDF57` and `new mPDF`).

**Steps:**
1. Add to root `composer.json`: `"mpdf/mpdf": "^8.0"` — run `composer install`
2. Enable `ext-gd` in `php.ini` (required by mPDF 8)
3. In each file using mPDF, replace:
   ```php
   // OLD
   require_once ROOT_PATH . 'application/helpers/MPDF57/mpdf.php';
   $mpdf = new mPDF();

   // NEW
   // (autoloaded — no require_once needed)
   $mpdf = new \Mpdf\Mpdf();
   ```
4. Delete the entire `application/helpers/MPDF57/` directory

#### Twilio SDK 6.35.1 → 8.x

**Location:** `application/controllers/Twillio/composer.json`

**Steps:**
1. Update the `"twilio/sdk"` version constraint to `"^8.0"` in `Twillio/composer.json`
2. Run `composer update` in the `Twillio/` directory
3. The API surface (`Twilio\Rest\Client`, `$client->messages->create()`) is unchanged between v6 and v8 — no code changes expected

#### Authorize.Net SDK (`sdk-php-master/`)

The bundled `sdk-php-master/` is a pre-Composer legacy SDK. PHP 8 compatibility is not guaranteed.

**Recommendation:** Defer to a dedicated sprint. This requires a full rewrite of all Authorize.Net payment processing code using the current official Authorize.Net PHP SDK. Do not attempt this as part of the PHP version upgrade — isolate it.

---

### 4.3 PHP 8.1 / 8.2 Deprecations

These will not prevent the app from booting but will generate warnings or trigger behavior changes that can break functionality.

#### Dynamic Property Creation (PHP 8.2 — Deprecated → Fatal in PHP 9)

**Scope:** All 53+ controllers that do `$this->option_arr = ...` in `beforeFilter()` without declaring the property in the class body.

**Pattern to fix:**
```php
// Each affected controller currently does this in beforeFilter():
$this->option_arr = $OptionModel->getAllPairValues();
// PHP 8.2: Deprecated: Creation of dynamic property ClassName::$option_arr

// Fix: add declaration to every affected controller class body:
class Admin extends Controller {
    var $option_arr = null;   // <-- add this
    // ...
}
```

The `priestModule` has a `tools/fix-dynamic-option-arr.php` automated script that applied this fix across 26+ controllers — adapt it for pujaModule's 53+ controllers.

#### `date_default_timezone_set(null)` (PHP 8.1 — Deprecated)

**File:** `application/controllers/Admin.php` line 16 (and expected across most controllers)

**Pattern:**
```php
// BEFORE — breaks when 'timezone' key is null/missing:
date_default_timezone_set($this->tpl['option_arr_values']['timezone']);

// AFTER — safe:
$tz = $this->tpl['option_arr_values']['timezone'] ?? '';
if ($tz) { date_default_timezone_set($tz); }
```

The `priestModule` has a `tools/fix-timezone-null-guard.php` automated tool — adapt for pujaModule.

#### `${var}` String Interpolation Syntax (PHP 8.2 — Deprecated)

| File | Line | Issue | Fix |
|---|---|---|---|
| `application/helpers/stripe/lib/Stripe/SingletonApiResource.php` | 19 | `"/v1/${base}"` | Change to `"/v1/{$base}"` |
| `application/helpers/stripe/lib/Stripe/ApiResource.php` | 56 | `"/v1/${base}s"` | Change to `"/v1/{$base}s"` |

Note: `${...}` patterns in view files are JavaScript template literals inside HTML — PHP never processes them and no change is needed there.

#### Interface Return Type Compatibility (PHP 8.0)

| File | Method | Issue | Fix |
|---|---|---|---|
| `core/framework/BaseQuery.php` | `getIterator()` | Return type incompatible with `IteratorAggregate::getIterator(): Traversable` | Add `#[\ReturnTypeWillChange]` above the method |
| `core/framework/SelectQuery.php` | `count()` | Return type incompatible with `Countable::count(): int` | Add `#[\ReturnTypeWillChange]` above the method |
| `application/helpers/stripe/lib/Stripe/Object.php` | `offsetSet`, `offsetExists`, `offsetUnset`, `offsetGet` | `ArrayAccess` interface incompatibility | Add `#[\ReturnTypeWillChange]` before each of the 4 methods |

#### `strpos()` Loose Comparison (PHP 8 — Behavior Change)

| File | Issue | Fix |
|---|---|---|
| `core/framework/CommonQuery.php` ~line 109 | `strpos(...) \|\| strpos(...)` — falsy at position 0 | Add `!== false` to both calls |
| `core/framework/Model.class.php` ~line 278 | `if (strpos($column, ' '))` | Add `!== false` |

#### `0 == "string"` Loose Comparison (PHP 8.0 — Behavior Change)

PHP 8.0 changed `0 == "non-numeric-string"` from `true` to `false`. Audit all `==` comparisons in `core/framework/Object.class.php` (especially any `== 'NULL'` patterns) and any controller where one operand could be integer `0` and the other a string.

#### Passing `null` to Non-nullable Parameters (PHP 8.1)

**Pattern (common throughout models/controllers):**
```php
// BEFORE — $arr[0] undefined when query returns empty rows:
return $arr[0];

// AFTER — safe:
return $arr[0] ?? null;
```

Files to audit:
- `core/framework/Model.class.php` — `getI18n()`, `getbymemberid()`, `getparking()` methods
- `application/config/functions.inc.php` — `str_replace()` calls with potentially-null arguments
- All controllers that access `$arr[0]` after a query without an empty check

#### `mysqli` Exception Mode (PHP 8.1)

**File:** `application/config/functions.inc.php` (DB connection helper)

PHP 8.1 changed `mysqli` to throw exceptions by default. The `@new mysqli(...)` error suppression suppresses warnings but not exceptions.

**Fix:** Wrap the connection in a try/catch:
```php
try {
    $con = new mysqli($host, $user, $pass, $db);
} catch (\mysqli_sql_exception $e) {
    return null; // or handle appropriately
}
```

#### `safe_mode` ini Check (PHP 8.0 — Key Removed)

**File:** `core/libs/kcfinder/core/bootstrap.php` lines 30–31

`ini_get("safe_mode")` always returns `false` or empty since PHP 5.4. The code that calls it should be removed or commented out to avoid any warnings or unexpected branch execution.

---

## 5. Recommended Order of Work

Work through items in this order. Do not start the PHP migration until all Critical and High security items are done.

| # | Item | Priority | Effort | Notes |
|---|---|---|---|---|
| 1 | Remove all backup/history files | High | Low | Reduce attack surface first |
| 2 | Add `.htaccess` blocks for `.sql`, `.bak`, `config/` | High | Low | One-time config change |
| 3 | Remove commented-out production credentials | Critical | Low | Delete 4 lines from 2 files |
| 4 | Fix SQL injection in `ajax-db-search.php` | Critical | Low | Single file, single fix |
| 5 | Restrict CORS header from `*` to specific origin | High | Low | One-line `.htaccess` change |
| 6 | Fix error reporting configuration | Medium | Low | 2-file change |
| 7 | Add CSRF protection (base Controller + all views) | High | Medium | Use automated tool from priestModule |
| 8 | Add `h()` helper + XSS escaping sweep of views | High | High | 358 view files to audit |
| 9 | Replace `rand()` with `random_int()` / `random_bytes()` | Medium | Low | 2–3 methods |
| 10 | Move `config.php` outside web root | High | Low | Path update in `index.php` |
| 11 | Replace hardcoded `localhost` URLs with `INSTALL_URL` | Medium | Medium | Use automated tool from priestModule |
| 12 | Add file upload MIME validation | Medium | Low | 1–2 controllers |
| 13 | Fix `chmod(0777)` → `chmod(0644)` in uploader | Low | Low | 1 file |
| 14 | Add rate limiting to login + payment | Medium | Medium | New table + new class |
| — | **BEGIN PHP 8.2 MIGRATION** | — | — | — |
| 15 | Fix `mysql_*` in `Object.class.php` | Fatal | Low | 2 lines |
| 16 | Upgrade PHPMailer 5.2.4 → 6.x (Composer) | Fatal | Medium | Replace entire helper dir |
| 17 | Upgrade mPDF 5.7 → 8.x (Composer) | Fatal | Medium | Replace entire helper dir |
| 18 | Upgrade Twilio SDK 6 → 8 | Fatal | Low | `composer update` |
| 19 | Fix `${var}` interpolation in Stripe helper | Warning | Low | 2 lines in 2 files |
| 20 | Add `#[\ReturnTypeWillChange]` to framework interfaces | Warning | Low | 6 methods across 3 files |
| 21 | Fix `strpos()` loose comparisons in framework | Warning | Low | 2 files |
| 22 | Fix dynamic property creation (all 53+ controllers) | Error | Medium | Use automated tool from priestModule |
| 23 | Fix `date_default_timezone_set(null)` pattern | Warning | Medium | Use automated tool from priestModule |
| 24 | Add `?? null` guards for null-to-non-nullable params | Warning | Medium | Model + controller sweep |
| 25 | Wrap `mysqli` connection in try/catch | Warning | Low | 1 file |
| 26 | Remove `safe_mode` check from KCFinder bootstrap | Warning | Low | 1 file |
| 27 | Audit `0 == "string"` loose comparisons | Behavior | Medium | Framework files primarily |
| 28 | Defer Authorize.Net SDK rewrite | — | High | Separate sprint |
| — | **BEGIN PHP 8.4 UPGRADE** | — | — | After 8.2 is stable — before Dec 2026 |
| 29 | Review PHP 8.3 / 8.4 changelog for new deprecations | Low | Low | Run `vendor/bin/phpunit` + error log check |
| 30 | Fix any new deprecations specific to 8.3 / 8.4 | Low | Low | Typically minimal after 8.2 is clean |
| 31 | Switch environment to PHP 8.4 and full regression | Low | Low | Same checklist as Phase 9 |

---

## 6. Testing Checklist

After security fixes and after the PHP migration, manually test all major workflows on PHP 8.2:

### Authentication
- [ ] Admin login / logout
- [ ] Password reset flow
- [ ] Role-based access for each of the 14+ user roles
- [ ] Twilio SMS OTP flow

### Puja Registration
- [ ] Early puja registration (member and non-member)
- [ ] Regular puja registration
- [ ] Puja registration status lookup
- [ ] PujaSankalpa registration
- [ ] PujaCart workflow

### Payments
- [ ] Online puja payments — Stripe path
- [ ] Online puja payments — Authorize.Net path
- [ ] Puja donations
- [ ] Associate payments and holds
- [ ] Discount code application

### Tickets & Passes
- [ ] PujaTicket purchase and admin management
- [ ] PujaPaidpasses
- [ ] PujaPassesadmin management
- [ ] Ticketadmin operations

### Food Coupons & Parking
- [ ] Food coupon purchase and redemption
- [ ] Paid parking registration and admin
- [ ] Parking admin management

### Badges & Reports
- [ ] Badge creation and CSV import (`Badges.php`)
- [ ] Badge report generation
- [ ] Sponsorship and SponsorItem management

### Content & Communication
- [ ] PujaMagazine subscription
- [ ] PujaMagazineadmin
- [ ] Mailinoption
- [ ] Email send via PHPMailer 6 (after upgrade)
- [ ] PDF generation via mPDF 8 (after upgrade)

### Calendar & Booking
- [ ] GzFront priest booking (slot selection → payment flow)
- [ ] Calendar admin management
- [ ] TimePrice configuration

### Member & Utility
- [ ] Member registration and edit
- [ ] Member lookup (`ajax-db-search.php`)
- [ ] Member log
- [ ] Statistics / Reporting
- [ ] Installer (verify it runs cleanly)

### Runtime Error Monitoring (PHP 8.2 Switch)
After switching the dev environment to PHP 8.2, monitor the Apache error log:
```
tail -f /xampp/apache/logs/error.log
```
Expected common errors to work through:
- `Undefined array key 0` — add `?? null` guards
- `Deprecated: Creation of dynamic property` — declare `var $option_arr = null;`
- `Deprecated: date_default_timezone_set(): Passing null` — add `$tz ?? ''` guard
- `TypeError: explode(): Argument #2 must be of type string, null given` — add `?? ''`
- `Deprecated: ${var} string interpolation` — fix Stripe helper files
- `Fatal: Cannot access offset of type string on string` — fix `ksort(false)` patterns

---

## Related Documents

- [`codebase-observations.md`](./codebase-observations.md) — Full codebase audit
- [`security-remediation-plan.md`](./security-remediation-plan.md) — Original security fix steps
- [`php8-migration-plan.md`](./php8-migration-plan.md) — Original PHP migration plan
- [`test-results-red-phase.md`](./test-results-red-phase.md) — Security test baseline

---

_End of document._
