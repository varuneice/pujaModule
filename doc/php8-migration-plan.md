# PHP 7.4 → 8.x Migration Plan
_Generated: 2026-03-12_

---

## Overview

The application currently runs **PHP 7.4.30** (built June 2022), which reached end-of-life on **November 28, 2022** and no longer receives security patches. The target upgrade version is **PHP 8.2 (LTS)**, supported until December 2026.

This document outlines the full migration path based on a static scan of the codebase.

---

## Target Version Recommendation

| Version | Support Until | Recommendation |
|---|---|---|
| PHP 8.0 | EOL Nov 2023 | Skip |
| PHP 8.1 | EOL Nov 2024 | Skip |
| **PHP 8.2** | Dec 2026 | **Recommended target** |
| PHP 8.3 | Nov 2027 | Acceptable, slightly more risk |

Go straight to **PHP 8.2** — it skips two already-EOL versions and gives the longest remaining support window without jumping to the bleeding edge.

---

## Phase 1 — Audit & Preparation

> Do this before touching any code.

1. Set up a **dedicated dev/test environment** — never run migration work against production
2. Enable **full error reporting** (`E_ALL`) in the dev environment so nothing is silently hidden
3. Run a **static analysis tool** against the codebase to generate a full automated compatibility report:
   - [PHP Rector](https://getrector.com/) — automated upgrade tool
   - [PHPCompatibility](https://github.com/PHPCompatibility/PHPCompatibility) — detects version-specific issues
4. Take a **full backup** of all files and the database before any changes begin
5. Set up **version control (Git)** if not already in place, to track all migration changes

---

## Phase 2 — Fix Fatal Errors (PHP 8.0 Hard Breaks)

These will cause immediate fatal errors on PHP 8.0+ — the application will not boot until resolved.

### 2a. `mysql_*` Functions (Removed in PHP 7.0, fatal in 8.x)

| File | Line(s) | Issue |
|---|---|---|
| `core/framework/Object.class.php` | 10–11 | `mysql_query()`, `mysql_fetch_assoc()` — same file as priestModule |
| `application/helpers/PHPMailer_5.2.4/examples/test_db_smtp_basic.php` | 35–40 | `MYSQL_CONNECT()`, `mysql_select_db()`, `MYSQL_QUERY()`, `mysql_fetch_array()` |

**Action:** Replace all `mysql_*` calls with `mysqli_*` equivalents or PDO. Note: the PHPMailer 5.2.4 issue is best resolved by upgrading to PHPMailer 6.x (see Phase 3).

---

### 2b. `each()` Function (Removed in PHP 8.0)

| File | Line(s) | Issue |
|---|---|---|
| `application/helpers/MPDF57/mpdf.php` | Multiple | `each()` in `while(list(...) = each(...))` loops |
| `application/helpers/PHPMailer_5.2.4/class.phpmailer.php` | 2050 | `each()` in while loop |
| `application/helpers/PHPMailer_5.2.4/class.smtp.php` | 544, 573 | `@each()` in while loops |

**Action:** Replace all `each()` patterns with `foreach`. Preferred fix: **upgrade the libraries** (see Phase 3) — mPDF 8 and PHPMailer 6 are already PHP 8-compatible.

---

### 2c. `get_magic_quotes_*` / `set_magic_quotes_*` (Removed in PHP 8.0)

| File | Line(s) | Issue |
|---|---|---|
| `application/helpers/MPDF57/compress.php` | 91, 96 | `get_magic_quotes_runtime()`, `set_magic_quotes_runtime(0)` |
| `application/helpers/MPDF57/mpdf.php` | 9478, 9480 | `ini_get("magic_quotes_runtime")` |
| `application/helpers/PHPMailer_5.2.4/class.phpmailer.php` | 1856–1870 | Multiple magic_quotes get/set calls |
| `application/controllers/GzFront.php` | To be confirmed via grep | `get_magic_quotes_gpc()` — present in priestModule equivalent |

**Action:** Remove all magic_quotes function calls entirely. Magic quotes were removed in PHP 5.4; these calls serve no purpose and will fatal on PHP 8.0+. The MPDF and PHPMailer issues are resolved by upgrading those libraries (Phase 3).

---

### 2d. Other Removed Functions to Audit

| Function | Removed In | Action |
|---|---|---|
| `create_function()` | PHP 8.0 | Replace with anonymous functions (`function() {}`) |
| `__autoload()` | PHP 8.0 | Replace with `spl_autoload_register()` |
| `hebrevc()` | PHP 8.0 | Replace with equivalent logic |
| `ctype_*` on non-string | PHP 8.1 | Ensure string arguments passed |

**Action:** Run a full codebase grep for these function names to confirm presence/absence.

---

## Phase 3 — Upgrade Third-party Libraries

All four key bundled libraries are incompatible with PHP 8.x and must be upgraded.

| Library | Current Version | Target Version | Notes |
|---|---|---|---|
| **PHPMailer** | 5.2.4 | 6.x (Composer) | Resolves `each()`, `magic_quotes`, and `mysql_*` issues |
| **mPDF** | 5.7 | 8.x (Composer) | Resolves `each()` and `magic_quotes` issues |
| **Authorize.Net SDK** | `sdk-php-master` (legacy) | — | Requires complete integration rewrite — recommended to defer or replace |
| **Twilio SDK** | 6.35.1 (in `controllers/Twillio/vendor/`) | 8.x (Composer update) | API-compatible upgrade |

### Steps

**PHPMailer 5.2.4 → 6.x:**
1. Add `phpmailer/phpmailer:"^6.0"` to root `composer.json`; run `composer install`
2. In each controller that uses PHPMailer: add `use PHPMailer\PHPMailer\PHPMailer;` + `use PHPMailer\PHPMailer\Exception as PHPMailerException;`
3. Remove all `require_once` references to `helpers/PHPMailer_5.2.4/`
4. Fix any `catch (phpmailerException)` → `catch (PHPMailerException)`
5. Add `require_once ROOT_PATH . 'vendor/autoload.php';` to `index.php` or `config.php`

**Known files that use PHPMailer** (verify via grep for `PHPMailer_5.2.4`):
- `application/controllers/App.php`
- Any other controller sending email (check for `require_once` of PHPMailer path)

**mPDF 5.7 → 8.x:**
1. Add `mpdf/mpdf:"^8.0"` to root `composer.json`; run `composer install`
2. Enable `ext-gd` in `php.ini` if not already enabled (required by mPDF 8)
3. In each model/controller that uses mPDF: change `new mPDF()` → `new \Mpdf\Mpdf()`
4. Remove all `require_once` / `include_once` references to `helpers/MPDF57/`

**Known files that use mPDF** (verify via grep for `MPDF57` and `new mPDF`):
- Models in `application/models/` that generate PDF reports
- Any controller that generates invoices or badge PDFs

**Twilio SDK:**
1. Update `application/controllers/Twillio/composer.json`: bump `"twilio/sdk"` constraint to `"^8.0"`
2. Run `composer update` in the `Twillio/` directory
3. API — `Twilio\Rest\Client` and `$client->messages->create()` — unchanged between v6 and v8

**Authorize.Net SDK:**
- The bundled `sdk-php-master/` is a pre-Composer era SDK. It works on PHP 7.4 but compatibility with PHP 8.x is not guaranteed
- Recommended: defer to a dedicated sprint; requires full rewrite of all Authorize.Net payment processing code using the current official SDK

---

## Phase 4 — Fix Deprecations (PHP 8.1 / 8.2 Warnings & Breaks)

### 4a. `safe_mode` ini Checks

| File | Line(s) | Issue |
|---|---|---|
| `application/helpers/PHPMailer_5.2.4/class.phpmailer.php` | 513, 930 | `ini_get("safe_mode")` — **no action needed** if PHPMailer 6 is installed (file no longer loaded) |
| `core/libs/kcfinder/core/bootstrap.php` | 30–31 | `if (ini_get("safe_mode")) die(...)` — must be removed/commented out |

---

### 4b. Loose Type Comparison Behavior Change (PHP 8.0)

PHP 8.0 changed the behavior of `0 == "non-numeric-string"` (now `false`; was `true` in PHP 7). Audit all `==` comparisons in the codebase where one operand could be `0` and the other a string.

Key file to check:
- `core/framework/Object.class.php` — any `== 'NULL'` comparison patterns

---

### 4c. Passing `null` to Non-nullable Parameters (PHP 8.1)

PHP 8.1 deprecated (PHP 9.0 will remove) passing `null` to parameters that do not accept `null`. The most common pattern in this codebase:

```php
// BEFORE — $arr[0] may be undefined when query returns empty:
return $arr[0];

// AFTER — safe:
return $arr[0] ?? null;
```

Files to audit (same framework files as priestModule — identical issues expected):
- `core/framework/Model.class.php` — `getI18n()`, `getbymemberid()`, `getparking()` methods
- `application/config/functions.inc.php` — `str_replace()` calls with potentially-null replacement values
- All controllers that access `$arr[0]` after a query without an empty check

---

### 4d. `${var}` String Interpolation Syntax (Deprecated in PHP 8.2)

| File | Line | Fix |
|---|---|---|
| `application/helpers/stripe/lib/Stripe/SingletonApiResource.php` | 19 | `"/v1/${base}"` → `"/v1/{$base}"` |
| `application/helpers/stripe/lib/Stripe/ApiResource.php` | 56 | `"/v1/${base}s"` → `"/v1/{$base}s"` |

Note: `${...}` occurrences in view files are **JavaScript template literals** inside `T_INLINE_HTML` — PHP never processes them. No changes needed there.

---

### 4e. Dynamic Property Creation (Deprecated in PHP 8.2)

PHP 8.2 disallows creating class properties dynamically (assigning `$this->property` without declaring the property in the class body). Common pattern in this codebase:

```php
// In beforeFilter():
$this->option_arr = $OptionModel->getAllPairValues();
// Will cause: Deprecated: Creation of dynamic property ClassName::$option_arr
```

**Action:** Add `var $option_arr = null;` to the class body of every controller that sets `$this->option_arr`. See priestModule `tools/fix-dynamic-option-arr.php` for an automated tool that applied this fix across 26+ controllers — adapt for pujaModule's 53+ controllers.

---

### 4f. `strpos()` Loose Comparison Patterns

| File | Line | Issue | Fix |
|---|---|---|---|
| `core/framework/CommonQuery.php` | ~109 | `strpos(...) \|\| strpos(...)` — falsy at position 0 | Add `!== false` to both calls |
| `core/framework/Model.class.php` | ~278 | `if (strpos($column, ' '))` | Add `!== false` |

---

### 4g. `date_default_timezone_set()` with null (Deprecated in PHP 8.1)

Pattern found across all controllers in priestModule:

```php
// BEFORE:
date_default_timezone_set($this->tpl['option_arr_values']['timezone']);
// Deprecated when 'timezone' key is null (DB unavailable)

// AFTER:
$tz = $this->tpl['option_arr_values']['timezone'] ?? '';
if ($tz) { date_default_timezone_set($tz); }
```

All controllers in pujaModule that call `date_default_timezone_set()` will need this null guard. See priestModule `tools/fix-timezone-null-guard.php` for the automated fix script.

---

### 4h. mysqli Exception Mode (PHP 8.1)

PHP 8.1 changed `mysqli` to throw exceptions by default. Suppressed `@new mysqli(...)` calls suppress warnings but **not exceptions**.

| File | Location | Fix |
|---|---|---|
| `application/config/functions.inc.php` | DB connection helper | Wrap in `try { } catch (\mysqli_sql_exception $e) { return null; }` |

---

### 4i. PDO Exception Mode (PHP 8.0)

PHP 8.0 changed PDO default error mode from `ERRMODE_SILENT` (return false) to `ERRMODE_EXCEPTION` (throw). Any code that checks `if ($result->execute() === false)` or relies on `execute()` returning false on error will break.

| File | Location | Fix |
|---|---|---|
| `core/framework/BaseQuery.php` | `execute()` method | Wrap `$result->execute($parameters)` in `try/catch(\PDOException)` to restore PHP 7 return-false behavior |

---

### 4j. Interface Return Type Compatibility (PHP 8.0)

| File | Line | Issue | Fix |
|---|---|---|---|
| `core/framework/BaseQuery.php` | `getIterator()` | Return type incompatible with `IteratorAggregate::getIterator(): Traversable` | Add `#[\ReturnTypeWillChange]` attribute |
| `core/framework/SelectQuery.php` | `count()` | Return type incompatible with `Countable::count(): int` | Add `#[\ReturnTypeWillChange]` attribute |
| `application/helpers/stripe/lib/Stripe/Object.php` | `offsetSet/offsetExists/offsetUnset/offsetGet` | `ArrayAccess` interface incompatibility | Add `#[\ReturnTypeWillChange]` before each of the 4 methods |

---

## Phase 5 — Regression Testing

Given the application has no automated test suite, this phase requires thorough manual testing across all major puja workflows.

### Test Checklist

#### Admin & Authentication
- [ ] Admin login / logout
- [ ] Password reset flow
- [ ] Role-based access for each of the 14+ user roles
- [ ] Twilio SMS OTP flow (if used)

#### Puja Registration
- [ ] Early puja registration (member and non-member)
- [ ] Regular puja registration
- [ ] Puja registration status lookup
- [ ] PujaSankalpa registration
- [ ] PujaCart workflow

#### Payments
- [ ] Online puja payments (Stripe path)
- [ ] Online puja payments (Authorize.Net path)
- [ ] Puja donations
- [ ] Associate payments and holds
- [ ] Discount code application

#### Tickets & Passes
- [ ] PujaTicket purchase and admin management
- [ ] PujaPaidpasses
- [ ] PujaPassesadmin management
- [ ] Ticketadmin operations

#### Food Coupons & Parking
- [ ] Food coupon purchase and redemption
- [ ] Paid parking registration and admin
- [ ] Parking admin management

#### Badges & Reports
- [ ] Badge creation and CSV import (`Badges.php`)
- [ ] Badge report generation
- [ ] Sponsorship and SponsorItem management

#### Content & Communication
- [ ] PujaMagazine subscription
- [ ] PujaMagazineadmin
- [ ] Mailinoption
- [ ] Email send via PHPMailer (after upgrade)
- [ ] PDF generation via mPDF (after upgrade)

#### Calendar & Booking
- [ ] GzFront priest booking (full slot selection → payment flow)
- [ ] Calendar admin management
- [ ] TimePrice configuration

#### Member & Utility
- [ ] Member registration and edit
- [ ] Member lookup (ajax-db-search.php)
- [ ] Member log
- [ ] Statistics / Reporting
- [ ] Installer (verify it runs cleanly)

### Runtime Error Monitoring

After switching the dev environment to PHP 8.2:
1. Monitor Apache error log continuously: `tail -f /xampp/apache/logs/error.log`
2. Work through errors batch by batch, fixing fatals before warnings
3. Common patterns to expect (based on priestModule experience):
   - `Undefined array key 0` — add `?? null` guards
   - `Deprecated: Creation of dynamic property` — declare `var $option_arr = null;`
   - `Deprecated: date_default_timezone_set(): Passing null` — add `$tz ?? ''` guard
   - `TypeError: explode(): Argument #2 must be of type string, null given` — add `?? ''` to string parameters
   - `Fatal: Cannot access offset of type string on string` — fix `ksort(false)` patterns (strtotime returning false)
   - `Deprecated: ${var} string interpolation` — fix in Stripe helper files
   - Missing view stub files — create empty stubs for controllers that echo directly

---

## Notes on pujaModule-Specific Differences from priestModule

- **More controllers (53+ vs 40+):** The dynamic property fix (`$option_arr` declaration) and timezone null guard will need to be applied to more files. The automated tools from priestModule can be reused with minor path adjustments.
- **Backup file naming:** pujaModule uses `_06Sep2023_bkp`, `_HIST_10_OCT_2024`, and `backup10july` naming — these patterns differ from priestModule's `backup.php` / `_23_may.php` style. Glob patterns in any automated tools need to be updated.
- **No `ajax-db-search-lookup.php`:** priestModule had a second AJAX search file; pujaModule appears to have only `ajax-db-search.php`. Confirm via grep.
- **CORS header:** pujaModule `.htaccess` adds `Access-Control-Allow-Origin: *` — priestModule did not have this. This is a security issue (see `security-remediation-plan.md` Phase 10) and is not a PHP 8 concern per se, but should be resolved during the security remediation phase before the PHP migration.
- **Twilio location:** `application/controllers/Twillio/` (same as priestModule) — upgrade path is identical.

---

## Related Documents

- [`codebase-observations.md`](./codebase-observations.md) — Full codebase audit
- [`security-remediation-plan.md`](./security-remediation-plan.md) — Security fixes (do this first)
- [`test-results-red-phase.md`](./test-results-red-phase.md) — Security test baseline

---

_End of document._
