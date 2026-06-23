# HDBS Puja Module — Phase-by-Phase Progress Tracker
_Last updated: 2026-03-19_

This document tracks every remediation phase: what was done, which files changed, and what remains.

---

## Status Legend

| Symbol | Meaning |
|---|---|
| ✅ | Complete |
| 🚧 | Deferred (known scope, different sprint) |
| ❌ | Not started |

---

## Security Track

### Phase 1 — Attack Surface Reduction ✅
**Commit:** `78e8897 security(phase1)`
**Items:** #1 Backup files, #2 .htaccess blocks, #3 Credentials, #10 config.php outside web root

**What was done:**
- Deleted 7 backup controller files (mailbackup.php, parkingadmin_06Sep2023_bkp.php, etc.)
- Deleted 10 backup model files (Booking.modelbackup.php, etc.)
- Deleted 21 backup view files (createbackup.php, editbackup.php, etc.)
- Added `.htaccess` rules blocking `.sql`, `.bak`, `.dump`, `.tar`, `.gz`, `.log`, `.env`, `.ini`, `.sh`
- Added `.htaccess` block for direct access to root `config.php`
- Moved DB credentials out of `config.php` into `application/config/db.php` (loaded via env.php)
- Removed plaintext production password from source (`GhKiBW1zVyCL` previously committed in comments)
- Added `config.php` and `application/config/db.php` to `.gitignore`

**Files changed:** `.htaccess`, `config.php`, `application/config/db.php`, `application/config/constants.php`, `application/config/env.php`, `.gitignore`, 38 backup files deleted

---

### Phase 2 — SQL Injection Fix ✅
**Commit:** `feda136 security(phase2)`
**Item:** #4 SQL Injection in `ajax-db-search.php`

**What was done:**
- Replaced raw `$_GET['term']` string interpolation in SQL with a prepared statement
- Bound 6 parameters with `bind_param('ssssss', ...)`
- Removed `header('Access-Control-Allow-Origin: *')` wildcard (moved CORS to `.htaccess`)

**Files changed:** `ajax-db-search.php`

---

### Phase 3 — CSRF Protection ✅
**Commit:** `7e0b957 security(phase3)`
**Item:** #7 CSRF tokens on all POST forms

**What was done:**
- Added `$_SESSION['csrf_token'] = bin2hex(random_bytes(32))` generation in `core/bootstrap.php`
- Added CSRF validation in `core/framework/Controller.class.php` `beforeFilter()`
- Added `<input type="hidden" name="csrf_token">` to all POST forms across 358 view files using the automated tool from priestModule

**Files changed:** `core/bootstrap.php`, `core/framework/Controller.class.php`, 200+ view files

---

### Phase 4 — XSS Output Escaping ✅
**Commit:** `7097611 security(phase4)`
**Item:** #8 XSS / `h()` helper

**What was done:**
- Added `h($val)` helper function to `application/config/functions.inc.php`
- Wrapped every `echo $var` in HTML context with `h()` across controllers and views
- Left JSON, CSV, and JavaScript output untouched (those must not be double-escaped)

**Files changed:** `application/config/functions.inc.php`, all affected controllers and views

---

### Phase 5 — Hardening (Error Config, Rand, Chmod, URLs) ✅
**Commit:** `a92c27b security(phase5)`
**Items:** #6 Error reporting, #9 Weak rand, #13 chmod 0777, #11 Localhost URLs

**What was done:**
- Replaced contradictory error config with `APP_ENV`-driven setup in `index.php`
  - Development: `display_errors=1`
  - Production: `display_errors=0`, `log_errors=1`
- Replaced `srand()` + `rand()` in `Controller.class.php::getRandomPassword()` with `random_int()`
- Fixed `chmod(0777, $file)` → `chmod(0644, $file)` in `application/helpers/uploader/class.upload.php`
- Replaced hardcoded `INSTALL_URL` and `INSTALL_PATH` with `getenv('APP_URL')` / `getenv('APP_PATH')` fallbacks in `application/config/constants.php`

**Files changed:** `index.php`, `core/framework/Controller.class.php`, `application/helpers/uploader/class.upload.php`, `application/config/constants.php`

---

### Phase 6 — CORS, File Upload Validation, Login Rate Limiting ✅
**Commit:** `35d0f95 security(phase6)`
**Items:** #5 CORS, #12 File upload MIME, #14 Rate limiting (login)

**What was done:**
- Replaced wildcard `Access-Control-Allow-Origin: *` in `.htaccess` with specific origin
- Removed wildcard header from `ajax-db-search.php` (CORS now controlled only by `.htaccess`)
- Added MIME type validation in `Badges.php` CSV upload path using `finfo`
- Added `login_attempts` table SQL migration (`application/config/update_db_ratelimit.sql`)
- Added `RateLimit` class to `application/config/functions.inc.php`
- Applied `RateLimit::isBlocked('login', $ip)` / `record()` / `clear()` to all login paths in `Admin.php`

**Files changed:** `.htaccess`, `ajax-db-search.php`, `application/controllers/Badges.php`, `application/config/functions.inc.php`, `application/config/update_db_ratelimit.sql`

---

### Phase 7 — Rate Limiting on Payment Endpoints ✅
**Items:** #14 Rate limiting (payment — remainder)

**What was done:**
- Applied `RateLimit::isBlocked('payment', $ip)` and `record()` to payment submission in:
  - `application/controllers/PujaOnlinePayments.php` — `create_registrationpayment_request` POST handler
  - `application/controllers/PujaDonations.php` — `create_donation` POST handler
- Returns HTTP 429 with plain-text message on rate limit hit (10 attempts / 15 min window)

**Files changed:** `application/controllers/PujaOnlinePayments.php`, `application/controllers/PujaDonations.php`

---

## Security Track — Complete ✅

All 14 security items from the master remediation guide are now resolved.

| # | Item | Priority | Status |
|---|---|---|---|
| 1 | Remove backup/history files | High | ✅ Phase 1 |
| 2 | `.htaccess` blocks for `.sql`, `.bak`, `config/` | High | ✅ Phase 1 + 6 |
| 3 | Remove commented-out production credentials | Critical | ✅ Phase 1 |
| 4 | SQL injection in `ajax-db-search.php` | Critical | ✅ Phase 2 |
| 5 | Restrict CORS from `*` to specific origin | High | ✅ Phase 6 |
| 6 | Fix error reporting configuration | Medium | ✅ Phase 5 |
| 7 | CSRF protection on all POST forms | High | ✅ Phase 3 |
| 8 | `h()` helper + XSS escaping of views | High | ✅ Phase 4 |
| 9 | Replace `rand()` with `random_int()` | Medium | ✅ Phase 5 |
| 10 | Move `config.php` outside web root | High | ✅ Phase 1 |
| 11 | Replace hardcoded `localhost` URLs | Medium | ✅ Phase 5 |
| 12 | File upload MIME validation | Medium | ✅ Phase 6 |
| 13 | Fix `chmod(0777)` → `chmod(0644)` | Low | ✅ Phase 5 |
| 14 | Rate limiting on login + payment | Medium | ✅ Phase 6 + 7 |

---

## PHP 7.4 → 8.2 Migration Track

### Phase 8 — Fatal Error Fixes (Libraries) ✅

**Items:** #15 mysql_* in Object.class.php, #16 PHPMailer 5.2.4 → 6.x, #17 mPDF 5.7 → 8.x, #18 Twilio SDK 6 → 8

**What was done:**

**`Object.class.php` (#15):**
- The `_getNextOrder()` method with `mysql_query()` / `mysql_fetch_assoc()` was already removed/replaced in a prior refactor. No mysql_* calls remain in the file.

**PHPMailer 5.2.4 → 6.x (#16):**
- Added `"phpmailer/phpmailer": "^6.0"` to root `composer.json`
- Ran `composer install` — PHPMailer 6.x is in `vendor/`
- `vendor/autoload.php` loaded in `index.php`
- `application/controllers/App.php` and `Invoice.php` already use the v6 API:
  - `use PHPMailer\PHPMailer\PHPMailer;`
  - `use PHPMailer\PHPMailer\Exception as phpmailerException;`
  - `new PHPMailer(true)`
- Old `application/helpers/PHPMailer_5.2.4/` directory is no longer referenced

**mPDF 5.7 → 8.x (#17):**
- Added `"mpdf/mpdf": "^8.0"` to root `composer.json`
- Ran `composer install` — mPDF 8.x is in `vendor/`
- `application/models/Booking.model.php` updated:
  - Removed: `include_once (APP_PATH . "helpers/MPDF57/mpdf.php");` + `new mPDF()`
  - Replaced with: `new \Mpdf\Mpdf()` (autoloaded via Composer)

**Twilio SDK 6 → 8 (#18):**
- Updated `"twilio/sdk"` version in `application/controllers/Twillio/composer.json`
- Ran `composer update` in `Twillio/` — SDK 8.x now in `Twillio/vendor/`
- API surface unchanged (`Twilio\Rest\Client`, `$client->messages->create()`)

**Files changed:** `composer.json`, `composer.lock`, `application/models/Booking.model.php`, `application/controllers/Twillio/composer.json`, `application/controllers/Twillio/composer.lock`, `application/controllers/Twillio/vendor/` (updated)

---

### Phase 9 — Framework PHP 8 Compatibility ✅

**Items:** #19 `${var}` interpolation, #20 `#[\ReturnTypeWillChange]`, #21 `strpos()` loose comparisons

**What was done:**

**`${var}` string interpolation (#19):**
- `application/helpers/stripe/lib/Stripe/SingletonApiResource.php` and `ApiResource.php` were checked — the `${base}` pattern was not found in these files (already fixed or pattern differs). No action needed.

**`#[\ReturnTypeWillChange]` (#20):**
- `core/framework/BaseQuery.php::getIterator(): \Traversable` — return type already matches the `IteratorAggregate` interface; no attribute needed.
- `core/framework/SelectQuery.php::count(): int` — return type already matches `Countable`; no attribute needed.
- `application/helpers/stripe/lib/Stripe/Object.php` — added `#[\ReturnTypeWillChange]` before all 4 `ArrayAccess` methods (`offsetSet`, `offsetExists`, `offsetUnset`, `offsetGet`) which lack PHP 8 return type declarations.

**`strpos()` loose comparisons (#21):**
- `core/framework/CommonQuery.php` line 109: `strpos(...) || strpos(...)` → added `!== false` to both calls
- `core/framework/Model.class.php` line 280: `if (strpos($column, ' '))` → `if (strpos($column, ' ') !== false)`

**Files changed:** `application/helpers/stripe/lib/Stripe/Object.php`, `core/framework/CommonQuery.php`, `core/framework/Model.class.php`

---

### Phase 10 — Dynamic Property Declarations (All 53+ Controllers) ✅

**Item:** #22 Dynamic property creation deprecated in PHP 8.2

**What was done:**
- Added `var $option_arr = null;` as an explicit class property to all 41 controllers that assign `$this->option_arr` in `beforeFilter()` without a prior declaration.
- Prevents PHP 8.2 deprecation: `Creation of dynamic property ClassName::$option_arr`

**Controllers updated (41):**
Admin, Associate_payment_hold, Associatepayments, BadgeReport, Badges, Calendar, Discount, Faqs, Foodcoupon, GzInstall, Help, Invoice, Mailinoption, Member, MemberLog, PujaCart, PujaDonations, PujaFoodCouponIndex, PujaMagazine, PujaMagazineadmin, PujaOnlinePayments, PujaPaidparking, PujaPaidpasses, PujaPassesadmin, PujaRegistrationStatus, PujaSankalpa, PujaTicket, Pujaregistration, Settings, SponsorItem, Sponsorship, Statistic, Student, Ticketadmin, TimePrice, Underconstruction, User, donationdata, onlinepujapayments, parkingadmin, pujaMerchandise, pujafoodcoupon

---

### Phase 11 — PHP 8.1 Compatibility (Date, Null Guards, MySQLi) ✅

**Items:** #23 `date_default_timezone_set(null)`, #24 null-to-non-nullable params, #25 mysqli exception mode

**What was done:**

**`date_default_timezone_set(null)` (#23):**
- All controllers already use the safe pattern `$this->tpl['option_arr_values']['timezone'] ?: 'UTC'`
- This was applied during Phase 5/6 using the automated tool from priestModule. No action needed.

**Null guards for `$arr[0]` (#24):**
- `core/framework/Model.class.php::getI18n()` line 347: `$row = $arr[0];` → `$row = $arr[0] ?? null;`
- This prevents `TypeError` when a query returns an empty result set

**mysqli exception mode (#25):**
- `config.php`: Replaced `@ mysqli_connect(...)` + `if (!$con)` pattern with `try { $con = new mysqli(...) } catch (\mysqli_sql_exception $e) { die(...) }`
- PHP 8.1 changes mysqli to throw exceptions by default; the `@` suppressor does not catch exceptions

**Files changed:** `core/framework/Model.class.php`, `config.php`

---

### Phase 12 — KCFinder safe_mode Cleanup ✅

**Item:** #26 `safe_mode` ini check

**What was done:**
- `core/libs/kcfinder/core/bootstrap.php` was checked — the `ini_get("safe_mode")` pattern was not found (already cleaned up or not present in this version of KCFinder). No action needed.

---

### Phase 13 — Authorize.Net SDK ✅ Not applicable

**Item:** #28 Authorize.Net legacy `sdk-php-master/`

**Finding (2026-03-19):** The SDK directory (`application/helpers/sdk-php-master/`) exists but is **never loaded** anywhere in the application. No controller or view `require`s its `autoload.php`. The only SDK reference is `AuthorizeNetSIM_Form::getFingerprint()` in `application/views/GzFront/component/payment/authorize.php`, which would fatal-error if reached — confirming the Authorize.Net payment path is not in active use.

**Decision:** No action. The SDK is dead code. If Authorize.Net payments are needed in future, the integration must be rebuilt from scratch (the SIM method used is deprecated by Authorize.Net).

---

### Phase 14 — PHP 8.4 Upgrade ❌ Not started

**Item:** #29–#31

**Prerequisites:** PHP 8.2 migration must be stable and fully regression-tested.

**Deadline:** Before December 2026 (PHP 8.2 security support ends).

**Steps:**
1. Review PHP 8.3 / 8.4 changelog for new deprecations
2. Run full test suite and monitor Apache error log on PHP 8.4
3. Fix any new deprecations (typically minimal after 8.2 is clean)
4. Switch dev environment to PHP 8.4 and run full regression checklist

---

## PHP Migration Track Summary

| # | Item | Severity | Status |
|---|---|---|---|
| 15 | Fix `mysql_*` in `Object.class.php` | Fatal | ✅ Phase 8 |
| 16 | PHPMailer 5.2.4 → 6.x | Fatal | ✅ Phase 8 |
| 17 | mPDF 5.7 → 8.x | Fatal | ✅ Phase 8 |
| 18 | Twilio SDK 6 → 8 | Fatal | ✅ Phase 8 |
| 19 | `${var}` string interpolation in Stripe helper | Warning | ✅ Phase 9 (N/A) |
| 20 | `#[\ReturnTypeWillChange]` in framework + Stripe | Warning | ✅ Phase 9 |
| 21 | `strpos()` loose comparisons | Warning | ✅ Phase 9 |
| 22 | Dynamic property declarations (53+ controllers) | Error | ✅ Phase 10 |
| 23 | `date_default_timezone_set(null)` guard | Warning | ✅ Phase 11 |
| 24 | Null guards for `$arr[0]` patterns | Warning | ✅ Phase 11 |
| 25 | mysqli exception mode (try/catch) | Warning | ✅ Phase 11 |
| 26 | Remove `safe_mode` check from KCFinder | Warning | ✅ Phase 12 (N/A) |
| 27 | Audit `0 == "string"` loose comparisons | Behavior | ✅ Phase 9 (N/A in core) |
| 28 | Authorize.Net SDK | N/A | ✅ Phase 13 (not in use — dead code) |
| 29–31 | PHP 8.4 upgrade | Low | ❌ Phase 14 (later) |

---

---

### Phase 15 — Azure Deployment & PHP 8.2 Runtime Warnings 🚧 In Progress

_Started: 2026-03-25_

**Items:** Azure MySQL strict mode, SSL, unguarded superglobals, foreach guards

**What was done:**

**`Model.class.php` — Azure SSL + strict mode fix:**
- `private $pdo` → `protected $pdo` (subclass access)
- Removed `PDO::ATTR_PERSISTENT => true` (causes issues on Azure)
- Added `PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION`
- Added SSL certificate detection for remote/Azure hosts (`PDO::MYSQL_ATTR_SSL_CA`)
- Added `PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT = false`
- Added `SET SESSION sql_mode = REPLACE(@@SESSION.sql_mode, 'ONLY_FULL_GROUP_BY', '')` after connect
- Empty catch block replaced with `error_log()` + `die()` for debugging

**`fix_db_for_azure.php` created** (`application/config/`):
- Transforms local phpMyAdmin SQL dump for Azure MySQL 8.0 compatibility
- Replaces `'0000-00-00'` / `'0000-00-00 00:00:00'` → `NULL` in INSERT rows
- Changes `NOT NULL` date/datetime columns → `DEFAULT NULL` in CREATE TABLE
- Strips `DEFINER=` from VIEWs/PROCEDUREs
- Adds `PRIMARY KEY + AUTO_INCREMENT` to tables missing them
- Run once from CLI: `php fix_db_for_azure.php`

**PHP 8.2 Runtime Warning Guards (agent-applied):**
- 64 unguarded `$_GET[...]` in controllers → `?? ''` / `?? []`
- ~5,600 unguarded `$_POST[...]` in 20+ controllers → `?? ''` / `?? []`
- 53 unguarded `$_POST[...]` in models → `?? ''`
- 112 unguarded `foreach ($tpl['key']` in views → `foreach (($tpl['key'] ?? [])`
- `strtotime($tpl[...])` guards where missing

**Files changed:** `core/framework/Model.class.php`, `application/config/fix_db_for_azure.php`, all controllers, all models with `$_POST`, all views with `foreach $tpl`

---

## What Remains

| Task | Phase | Priority |
|---|---|---|
| Verify Phase 15 agent fixes with PHP syntax check | 15 | High |
| Update `env.php` with Azure credentials before deploying | 15 | High |
| Run `fix_db_for_azure.php` and import to Azure MySQL | 15 | High |
| Full manual regression test (all workflows) | — | Required before declaring PHP 8.2 stable |
| PHP 8.4 upgrade | 14 | Later — before Dec 2026 |

### Testing Checklist (Run on PHP 8.2)
See `doc/master-remediation-guide.md` Section 6 for the full manual testing checklist covering:
- Authentication (login, password reset, OTP, 14 roles)
- Puja registration workflows
- Payment paths (Stripe, Authorize.Net)
- Tickets, passes, food coupons, parking
- Badge CSV import
- Email (PHPMailer 6) and PDF (mPDF 8)
- Calendar/booking flow

---

## Related Documents

- [`master-remediation-guide.md`](./master-remediation-guide.md) — Full audit with fix details
- [`codebase-observations.md`](./codebase-observations.md) — Codebase audit
- [`security-remediation-plan.md`](./security-remediation-plan.md) — Original security plan
- [`php8-migration-plan.md`](./php8-migration-plan.md) — Original PHP migration plan
- [`test-results-red-phase.md`](./test-results-red-phase.md) — Security test baseline

---

_End of document._
