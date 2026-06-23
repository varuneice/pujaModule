# Security Remediation Plan
_Generated: 2026-03-12_

---

## Phase Progress Tracker

| Phase | Description | Status | Completed |
|---|---|---|---|
| 1 | Remove Exposed Data & Backup Files | Pending | — |
| 2 | SQL Injection | Pending | — |
| 3 | CSRF Protection | Pending | — |
| 4 | XSS Output Escaping | Pending | — |
| 5 | File Upload Validation | Pending | — |
| 6 | Credentials & Configuration | Pending | — |
| 7 | Weak Password Generation | Pending | — |
| 8 | Rate Limiting | Pending | — |
| 9 | Replace Hardcoded localhost URLs | Pending | — |
| 10 | CORS Header Restriction | Pending | — |

---

## Overview

This document outlines the steps required to address all security vulnerabilities identified during the initial codebase audit. Issues are grouped by priority and should be addressed in the order presented.

For the full list of identified vulnerabilities see [`codebase-observations.md`](./codebase-observations.md).

---

## Priority 1 — Critical (Fix Immediately)

### 1. Remove Exposed Backup Files & Secure Public Paths

Multiple backup PHP files exist in the active codebase and are potentially accessible via browser. These include old code with vulnerabilities, and in some cases historic credentials.

**Controllers to remove:**
- `application/controllers/mailbackup.php`
- `application/controllers/parkingadmin_06Sep2023_bkp.php`
- `application/controllers/PujaMagazine_06Sep2023_bkp.php`
- `application/controllers/PujaMagazineadmin_06Sep2023_bkp.php`
- `application/controllers/PujaPaidparking_06Sep2023_bkp.php`
- `application/controllers/PujaOnlinePayments2_July.php`
- `application/controllers/pujafoodcoupon_HIST_10_OCT_2024.php`

**Models to remove:**
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

**Views to remove:**
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
1. Run a glob/grep for `*backup*`, `*_bkp*`, `*_HIST_*`, `*_July*`, `*_may*`, `*_march*` across the codebase
2. Verify none of the files are in active use (check for any `require`/`include` references)
3. Delete all confirmed-unused backup files
4. Add root `.htaccess` rules to block direct browser access to `.sql`, `.bak`, `.dump`, `.tar`, `.log` files
5. Add an `.htaccess` to `application/config/` denying all HTTP access (the SQL migration files cannot be deleted but must not be web-accessible)
6. Use **Git branches** for version history going forward — backup copies of files have no place in a production codebase

---

### 2. Fix SQL Injection

Every place `$_GET`, `$_POST`, or `$_REQUEST` values are interpolated directly into SQL strings must be converted to **prepared statements with parameterized queries**.

**Files confirmed affected:**
- `ajax-db-search.php` (CRITICAL — public endpoint, no authentication required)

**Steps:**
1. Run a full codebase grep for `$_GET`, `$_POST`, `$_REQUEST` to produce a complete list of every injection point
2. For each occurrence, determine if the value is used in a SQL query
3. Replace raw string interpolation with PDO prepared statements or the existing custom query builder's parameterized methods
4. Pay special attention to the public-facing AJAX endpoint (`ajax-db-search.php`) — this is exploitable without authentication
5. After fixing, test each endpoint with SQL injection payloads to confirm they are no longer vulnerable

**The pattern to eliminate:**
```php
// UNSAFE — what currently exists
$query = "WHERE F_name LIKE '{$_GET['term']}%'";

// SAFE — parameterized prepared statement
$stmt = $con->prepare("WHERE F_name LIKE ? ...");
$term = $_GET['term'] . '%';
$stmt->bind_param('s', $term);
```

---

## Priority 2 — High

### 3. Add CSRF Protection

No CSRF tokens exist on any POST form. Any authenticated user can be tricked into submitting a form on their behalf.

**Steps:**
1. Generate a unique token per session:
   ```php
   $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
   ```
2. Embed the token as a hidden field in every POST form:
   ```html
   <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
   ```
3. Add validation to the **base `Controller` class** so it applies globally to all POST requests:
   ```php
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
           // reject request — 403
       }
   }
   ```
4. Call both token generation and validation from `Bootstrap::init()` (not `beforeFilter()`) — this ensures CSRF runs even if a controller overrides `beforeFilter()` without calling `parent::beforeFilter()`
5. Reject and log any request where the token is missing or mismatched

Note: See priestModule implementation for the `add-csrf-tokens.php` automated tool that inserts the hidden input into all view forms — a similar tool can be reused here.

---

### 4. Fix XSS (Cross-Site Scripting)

Unsanitized user data is echoed directly into HTML output and attributes across views and controllers.

**Steps:**
1. Create a global helper shorthand function for output escaping (if not already present):
   ```php
   function h($val) {
       return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
   }
   ```
   Add this to `application/config/functions.inc.php`.
2. Audit all 358 view files for any variable echoed into HTML — wrap every one with `h()`:
   ```php
   // UNSAFE
   echo "<input value='$value[Member_id]'/>";

   // SAFE
   echo "<input value='" . h($value['Member_id']) . "'/>";
   ```
3. In controllers, identify all `echo` statements that output to HTML pages and wrap with `htmlspecialchars()`
4. For JSON and CSV responses, use `print` instead of `echo` — `htmlspecialchars()` would corrupt the output format
5. Pay special attention to: HTML attribute values, reflected search terms, member names/emails/addresses, any data sourced from `$_GET` or `$_POST` echoed back to the page
6. Remove (or properly re-implement at output time) the commented-out SITELOCK input-sanitization block in `index.php` — sanitizing at input is the wrong layer

---

### 5. Restrict CORS Header

The `.htaccess` sets `Access-Control-Allow-Origin: *`, allowing any origin to make cross-origin requests.

**Steps:**
1. In `.htaccess`, replace the wildcard CORS header:
   ```apache
   # Remove this:
   Header set Access-Control-Allow-Origin "*"

   # Replace with the specific trusted origin(s):
   Header set Access-Control-Allow-Origin "https://your-production-domain.com"
   ```
2. If the wildcard is required for specific public API endpoints, restrict it to those paths only using `<FilesMatch>` or `<Location>` directives
3. If no cross-origin requests are needed at all, remove the header entirely

---

### 6. Add File Upload Validation

CSV imports and file uploads lack content-type or content validation.

**Steps:**
1. Validate MIME type **server-side** using `finfo_file()` — do not rely on file extension or browser-supplied MIME type:
   ```php
   $finfo = finfo_open(FILEINFO_MIME_TYPE);
   $mime = finfo_file($finfo, $tmp_path);
   if ($mime !== 'text/csv') { /* reject */ }
   ```
2. For CSV imports (Badges, etc.):
   - Validate that column headers match the expected schema before processing rows
   - Reject files with unexpected structure
   - Sanitize every cell value read from the CSV before using in queries
3. Set a maximum file size limit enforced server-side (not just `php.ini`)
4. Store uploaded files outside the web root where possible
5. Generate a random filename on upload — never use the original user-supplied filename

---

## Priority 3 — Medium

### 7. Secure Database Credentials

`config.php` and `constants.php` store credentials in plaintext. A real production password (`GhKiBW1zVyCL`) is visible in commented-out code in `constants.php`.

**Steps:**
1. **Immediately remove** the commented-out production credentials from `constants.php` source — these should never be in version control
2. Move `config.php` **outside the web root** and update the `require` path in `index.php`
3. Use environment variables or a `.env` file to store credentials:
   - Replace `define("DEFAULT_PASS", "")` with `define("DEFAULT_PASS", getenv('DB_PASS') ?: '')`
   - Same for `DEFAULT_USER`, `DEFAULT_HOST`, `DEFAULT_DB`
4. Add `.env` and `config.php` to `.gitignore`
5. Set a **strong password** on the MySQL database user — never use `root` with an empty password
6. Create a dedicated MySQL user with only the permissions the application needs

---

### 8. Fix Error Reporting Configuration

`error_reporting(0)` in `config.php` and `ini_set("display_errors", "On")` in `index.php` create a contradictory, insecure state.

**Steps:**
1. Remove `error_reporting(0)` from `application/config/config.php`
2. Remove `ini_set("display_errors", "On")` from `index.php`
3. Set environment-appropriate error reporting driven by an `APP_ENV` environment variable:

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
4. Remove the `@` error-suppression operators from `session_name()` and `session_start()` calls in `index.php` — these mask real errors

---

### 9. Fix Weak Password Generation

Password and invoice number generation uses `rand()` which produces predictable, weak values.

**Steps:**
1. Locate all uses of `rand()` and `srand()` used for security-sensitive purposes (passwords, tokens, invoice numbers)
2. Replace with cryptographically secure alternatives:
   ```php
   // For random integers (invoice numbers)
   $n = random_int(pow(10, $len - 1), (int)(pow(10, $len) - 1));

   // For tokens/passwords
   $token = bin2hex(random_bytes(32));

   // For readable passwords (index into a character set)
   $n = random_int(0, $alphaLength);
   ```
3. Update `Util::incrementalHash()` and `Util::random_password()` in `application/config/functions.inc.php`
4. Audit all controllers (especially `Admin.php`) for any remaining `rand()`/`srand()` calls used in security-sensitive contexts

---

### 10. Add Rate Limiting to Login & Payment Endpoints

No rate limiting exists on login or payment submission endpoints.

**Steps:**
1. Create a `login_attempts` table (see priestModule `update_db_11.sql` for schema reference):
   - Columns: `id`, `action`, `identifier`, `attempted_at`
   - Index on `(action, identifier, attempted_at)`
2. Implement a `RateLimit` class (see priestModule `functions.inc.php` for the `RateLimit` implementation):
   - `isBlocked($action, $identifier)` — check threshold
   - `record($action, $identifier)` — log an attempt
   - `clear($action, $identifier)` — clear on successful login
   - Fail open if DB is unavailable
3. Apply to `Admin.php` login POST block
4. Apply to payment submission POST blocks in `PujaOnlinePayments.php`, `Member.php` checkout, and `PujaDonations.php`
5. Configurable thresholds via environment variables

---

### 11. Replace Hardcoded localhost URLs

Email templates and other files contain `http://localhost:8082/HDBS_Payment/pujaModule/...` URLs that will break in any non-local environment.

**Steps:**
1. Run a grep for `localhost` across all PHP files to find every hardcoded URL
2. Ensure `INSTALL_URL` is defined in `application/config/constants.php` driven by environment:
   ```php
   define('INSTALL_URL', getenv('APP_URL') ?: 'http://localhost:8082/HDBS_Payment/pujaModule/');
   ```
3. Replace all hardcoded URLs in email templates, views, and controllers with `INSTALL_URL . '/path'`
4. See priestModule `tools/replace-localhost-urls.php` for an automated tokenizer-based approach — a similar tool can be adapted for pujaModule's URL pattern

---

## Recommended Order of Attack

| # | Action | Status | Reason |
|---|---|---|---|
| 1 | Delete all backup/history files | Pending | Eliminate attack surface from stale code |
| 2 | Add `.htaccess` protections (block `.sql`, `.bak`; protect `config/`) | Pending | Quick wins with immediate access control benefit |
| 3 | Fix SQL injection in `ajax-db-search.php` | Pending | Public-facing, requires no authentication to exploit |
| 4 | Audit and fix SQL injection in remaining controllers | Pending | Systematic full sweep |
| 5 | Add CSRF protection to base `Controller` | Pending | One change protects all 53+ controllers |
| 6 | Fix XSS across all views and controllers | Pending | Add `h()` helper, sweep all output points |
| 7 | Restrict CORS header from `*` to specific origin | Pending | Quick config change, significant security improvement |
| 8 | Secure credentials; fix error reporting configuration | Pending | Config-level changes, low implementation risk |
| 9 | Remove commented-out production credentials from `constants.php` | Pending | Immediate — historical credentials should never be in source |
| 10 | Fix weak random number generation | Pending | Upgrade `rand()` to `random_int()` / `random_bytes()` |
| 11 | Rate limiting | Pending | Implement once the rest of the app is stable |
| 12 | Replace hardcoded localhost URLs | Pending | Portability — use `INSTALL_URL` throughout |
| 13 | File upload validation | Pending | Add MIME type checks to all upload entry points |

---

## Related Documents

- [`codebase-observations.md`](./codebase-observations.md) — Full codebase audit and security observations
- [`test-results-red-phase.md`](./test-results-red-phase.md) — Security test baseline
- [`php8-migration-plan.md`](./php8-migration-plan.md) — PHP 7.4 to 8.x migration plan

---

_End of document._
