# HDBS Payment – Puja Module: Phased Implementation Plan
_Generated: 2026-03-16_

---

## How This Plan Works

Each phase follows a strict **Red → Fix → Green** cycle:

1. **Write the test first** (or define the manual check) — it must fail against the current code
2. **Make the change**
3. **Run the test** — it must now pass
4. **Regression** — run all previous tests to confirm nothing broke
5. **Commit** — one commit per phase, with a clear message

Each phase is independently deployable. If a phase goes wrong, roll back that single commit and the application is back to the previous working state.

**Golden rule:** Never start a new phase until all tests for the current phase are green and all prior tests still pass.

---

## Phase Overview

| Phase | Name | Type | Risk | Tests |
|---|---|---|---|---|
| 0 | Environment & Baseline | Setup | None | Baseline snapshot |
| 1 | File Cleanup & Config Hardening | Security | Low | Manual |
| 2 | SQL Injection Fix | Security | Low | Automated + Manual |
| 3 | CSRF Protection | Security | Medium | Automated + Manual |
| 4 | XSS Output Escaping | Security | Medium | Automated + Manual |
| 5 | Remaining Security Items | Security | Low–Medium | Automated + Manual |
| 6 | Library Upgrades (PHPMailer, mPDF, Twilio) | PHP Migration | Medium | Automated + Manual |
| 7 | Core Framework PHP 8.2 Fixes | PHP Migration | Low | Automated |
| 8 | Controller-wide PHP 8.2 Fixes | PHP Migration | Medium | Automated + Manual |
| 9 | PHP 8.2 Switch & Full Regression | PHP Migration | High | Full regression suite |
| 10 | PHP 8.4 Upgrade | PHP Migration | Low | Automated + Smoke test |

**Migration path:** PHP 7.4 → 8.2 (Phases 6–9) → 8.4 (Phase 10, before Dec 2026)

PHP 8.4 is the current stable release (active support until Nov 2026, security support until Nov 2028). PHP 8.2 is the intermediate target because the dev environment (xampp82) already runs it. The 7.4 → 8.x jump contains all the hard work. After Phase 9, upgrading from 8.2 → 8.4 is a short, low-risk step.

---

## Phase 0 — Environment & Baseline Setup

**Goal:** A safe, isolated dev environment with error reporting on, a clean Git baseline, and a test database ready. No production changes.

### Steps

#### 0.1 — Dev Environment
- Confirm you are working on `C:/xampp82/` (PHP 8.2) — **not** the production PHP 7.4 install
- Verify: open `http://localhost:8082/HDBS_Payment/pujaModule/?controller=Installer` — the app should load
- Note any errors or warnings already showing in the browser or in `C:/xampp82/apache/logs/error.log`

#### 0.2 — Enable Full Error Reporting in Dev
Temporarily edit `index.php` to force full error output during development:
```php
// Add immediately after the opening <?php tag, before anything else:
error_reporting(E_ALL);
ini_set('display_errors', '1');
```
This will be replaced with the proper env-aware config in Phase 5. For now it lets you see all issues.

#### 0.3 — Create Test Database
```sql
CREATE DATABASE hdbs_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- Import the schema into hdbs_test:
-- mysql -u root hdbs_test < application/config/database.sql
-- Run all update scripts in order: update1_db.sql through update_db_10.sql
```

#### 0.4 — Git Baseline
```bash
git add -A
git commit -m "baseline: pre-remediation snapshot before Phase 1 security work"
```

#### 0.5 — Set Up PHPUnit
Create `composer.json` at the project root (or update if one exists):
```json
{
    "require": {},
    "require-dev": {
        "phpunit/phpunit": "^10.0"
    },
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
    }
}
```
Run `composer install` in the project root. Verify: `vendor/bin/phpunit --version`

Create `phpunit.xml` at the project root:
```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit bootstrap="tests/bootstrap.php" colors="true">
    <testsuites>
        <testsuite name="Security">
            <directory>tests/Security</directory>
        </testsuite>
        <testsuite name="PHP8Compat">
            <directory>tests/Php8</directory>
        </testsuite>
    </testsuites>
</phpunit>
```

Create `tests/bootstrap.php`:
```php
<?php
define('ROOT_PATH', dirname(__DIR__) . '/');
define('APP_PATH',  ROOT_PATH . 'application/');
define('FRAMEWORK_PATH', ROOT_PATH . 'core/framework/');
define('MODELS_PATH', APP_PATH . 'models/');
define('CONTROLLERS_PATH', APP_PATH . 'controllers/');
define('VIEWS_PATH', APP_PATH . 'views/');
define('TEST_DB', 'hdbs_test');
```

#### 0.6 — Baseline Smoke Test (Manual)
Open each of these URLs and confirm they load without a white screen:
- `http://localhost:8082/HDBS_Payment/pujaModule/` — home/front page
- `http://localhost:8082/HDBS_Payment/pujaModule/?controller=Admin` — admin login page
- `http://localhost:8082/HDBS_Payment/pujaModule/?controller=GzFront` — booking front page
- `http://localhost:8082/HDBS_Payment/pujaModule/ajax-db-search.php?term=a` — AJAX search (returns JSON)

Record any existing errors — these are pre-existing, not introduced by your changes.

### Phase 0 — Done When
- [ ] Dev environment running on PHP 8.2 (confirm: `<?php phpinfo(); ?>` shows PHP 8.2.x)
- [ ] `hdbs_test` database created and schema imported
- [ ] PHPUnit installed and `vendor/bin/phpunit --version` prints without error
- [ ] All 4 smoke test URLs load
- [ ] Git baseline commit created

---

## Phase 1 — File Cleanup & Config Hardening

**Goal:** Remove all backup files, add .htaccess access controls, remove exposed credentials. Zero code logic changes — nothing that can break functionality.

### 1.1 — Write the Manual Verification Checks (Pre-fix)

Before deleting anything, run these checks to confirm files are unused:
```bash
# Confirm none of the backup controllers are require/include'd anywhere:
grep -rn "mailbackup\|parkingadmin_06Sep\|PujaMagazine_06Sep\|PujaMagazineadmin_06Sep\|PujaPaidparking_06Sep\|PujaOnlinePayments2_July\|pujafoodcoupon_HIST" \
    application/controllers/ application/models/ application/views/ index.php

# Same for backup models:
grep -rn "Booking\.modelbackup\|memberbackup16\|foodcouponprice_old\|pujafoodcouponold\|PujaTicketPrice_06Sep\|pujamagazine_06Sep\|paidparking_06Sep\|pujamagazineprice_06Sep\|ticket_06Sep\|ticketeventname_06Sep" \
    application/ index.php
```
Expected output: nothing. If any file is still referenced, investigate before deleting.

### 1.2 — Delete Backup Controllers
```bash
rm application/controllers/mailbackup.php
rm application/controllers/parkingadmin_06Sep2023_bkp.php
rm application/controllers/PujaMagazine_06Sep2023_bkp.php
rm application/controllers/PujaMagazineadmin_06Sep2023_bkp.php
rm application/controllers/PujaPaidparking_06Sep2023_bkp.php
rm application/controllers/PujaOnlinePayments2_July.php
rm application/controllers/pujafoodcoupon_HIST_10_OCT_2024.php
```

### 1.3 — Delete Backup Models
```bash
rm application/models/Booking.modelbackup.php
rm application/models/memberbackup16
rm application/models/foodcouponprice_old.model.php
rm application/models/pujafoodcouponold.model.php
rm application/models/PujaTicketPrice_06Sep2023_bkp.model.php
rm "application/models/pujamagazine_06Sep_2023_bkp.model.php"
rm application/models/paidparking_06Sep2023_bkp.model.php
rm application/models/pujamagazineprice_06Sep2023_bkp.model.php
rm application/models/ticket_06Sep2023_bkp.model.php
rm application/models/ticketeventname_06Sep2023_bkp.model.php
```

### 1.4 — Delete Backup Views
```bash
rm application/views/Badges/createbackup.php
rm application/views/Badges/editbackup.php
rm "application/views/Badges/edit(26julybackup)"
rm application/views/Calendar/settings/paymentbackup.php
rm application/views/GzFront/booking_formbackup.php
rm "application/views/GzFront/component/extra_formbackup10july.php"
rm application/views/GzFront/component10julybackup.php
rm "application/views/GzFront/component/booking_formbackup10july.php"
rm "application/views/GzFront/component/extra_formbackup.php"
rm application/views/GzFront/gettime_backup29may.php
rm application/views/Layouts/admin/menu/sidebarbackup.php
rm application/views/Member/createbackup.php
rm application/views/Member/editbackup.php
rm "application/views/parkingadmin/component/parking_registration_table_06Sep2023_bkp.php"
rm "application/views/parkingadmin/component/search_06Sep2023_bkp.php"
rm application/views/parkingadmin/index_06Sep2023_bkp.php
rm application/views/parkingadmin/edit_06Sep2023_bkp.php
rm application/views/parkingadmin/payment_06Sep2023_bkp.php
rm "application/views/PujaMagazine/PujaMagazine_06_Sep2023_bkp.php"
rm application/views/Preview/index7julybackup.php
rm application/views/Preview/index5julybackup.php
rm application/views/Preview/indexbackup
```

### 1.5 — Add .htaccess Protections

**Root `.htaccess`** — add these rules above the existing `RewriteEngine On` block:
```apache
# Block direct access to sensitive file types
<FilesMatch "\.(sql|bak|dump|tar|gz|log|env|ini|sh)$">
    Order allow,deny
    Deny from all
</FilesMatch>

# Restrict CORS to specific trusted origin (replace with actual domain)
<IfModule mod_headers.c>
    Header set Access-Control-Allow-Origin "https://your-production-domain.com"
</IfModule>

# Remove the old wildcard CORS line:
# Header set Access-Control-Allow-Origin "*"   <-- DELETE this line
```

**Create `application/config/.htaccess`** (new file — blocks direct HTTP access to SQL files):
```apache
Order allow,deny
Deny from all
```

### 1.6 — Remove Exposed Credentials

Edit `config.php` — delete the commented-out credential block entirely:
```php
// DELETE these lines:
// $DB_NAME='durgab5_HDBS_PaymentTesting';
// $DB_USER='durgab5_hdbsprod';
// $DB_PASS='GhKiBW1zVyCL';
```

Edit `application/config/constants.php` — delete the commented-out credential block:
```php
// DELETE these lines:
//     define("DEFAULT_USER", "durgab5_hdbsprod");
//     define("DEFAULT_PASS", "GhKiBW1zVyCL");
//     define("DEFAULT_DB", "durgab5_HDBS_PaymentTesting");
```

### 1.7 — Verification

**Automated check** — create `tests/Security/Phase1Test.php`:
```php
<?php
class Phase1Test extends PHPUnit\Framework\TestCase
{
    /** Backup files must not exist */
    public function testBackupControllersDeleted(): void {
        $files = glob(ROOT_PATH . 'application/controllers/*{backup,_bkp,_HIST,_July,_may}*', GLOB_BRACE);
        $this->assertEmpty($files, "Backup controllers still present: " . implode(', ', $files));
    }

    public function testBackupModelsDeleted(): void {
        $files = glob(ROOT_PATH . 'application/models/*{backup,_bkp,_HIST,_July,_may}*', GLOB_BRACE);
        $this->assertEmpty($files, "Backup models still present: " . implode(', ', $files));
    }

    public function testBackupViewsDeleted(): void {
        $files = glob(ROOT_PATH . 'application/views/**/*{backup,_bkp,_HIST,_July}*', GLOB_BRACE);
        $this->assertEmpty($files, "Backup views still present: " . implode(', ', $files));
    }

    /** Production password must not appear in source */
    public function testProductionPasswordNotInSource(): void {
        $configContent    = file_get_contents(ROOT_PATH . 'config.php');
        $constantsContent = file_get_contents(ROOT_PATH . 'application/config/constants.php');
        $this->assertStringNotContainsString('GhKiBW1zVyCL', $configContent,    'Production password found in config.php');
        $this->assertStringNotContainsString('GhKiBW1zVyCL', $constantsContent, 'Production password found in constants.php');
    }

    /** config/ directory must have an .htaccess blocking HTTP access */
    public function testConfigDirectoryHasHtaccess(): void {
        $this->assertFileExists(ROOT_PATH . 'application/config/.htaccess');
        $content = file_get_contents(ROOT_PATH . 'application/config/.htaccess');
        $this->assertStringContainsStringIgnoringCase('deny from all', $content);
    }

    /** Root .htaccess must not contain the wildcard CORS header */
    public function testCorsWildcardRemovedFromHtaccess(): void {
        $content = file_get_contents(ROOT_PATH . '.htaccess');
        $this->assertStringNotContainsString('Allow-Origin "*"', $content, 'Wildcard CORS still in .htaccess');
    }
}
```

Run: `vendor/bin/phpunit tests/Security/Phase1Test.php`
Expected: **5 tests, 5 passed**

**Manual check — confirm URLs still work after file deletion:**
- [ ] `http://localhost:8082/HDBS_Payment/pujaModule/?controller=Admin` loads (login page)
- [ ] `http://localhost:8082/HDBS_Payment/pujaModule/?controller=parkingadmin` loads (uses the real file, not the bkp)
- [ ] `http://localhost:8082/HDBS_Payment/pujaModule/?controller=PujaMagazine` loads
- [ ] `http://localhost:8082/HDBS_Payment/pujaModule/application/config/database.sql` → **403 Forbidden** (blocked by new .htaccess)
- [ ] `http://localhost:8082/HDBS_Payment/pujaModule/ajax-db-search.php?term=a` → still returns JSON

### Phase 1 — Done When
- [ ] All 5 automated tests pass
- [ ] No backup files remain (confirmed by tests)
- [ ] Production password not in any source file
- [ ] `.sql` files in `application/config/` return 403 in browser
- [ ] All smoke test URLs from Phase 0 still work
- [ ] Git commit: `security(phase1): remove backup files, protect config paths, remove exposed credentials`

---

## Phase 2 — SQL Injection Fix

**Goal:** Fix the critical public SQL injection in `ajax-db-search.php`. Single-file change.

### 2.1 — Write Tests First (Red Phase)

Create `tests/Security/SqlInjectionTest.php`:
```php
<?php
class SqlInjectionTest extends PHPUnit\Framework\TestCase
{
    /** Source code must not contain raw $_GET interpolation in SQL */
    public function testAjaxSearchHasNoRawInterpolation(): void {
        $source = file_get_contents(ROOT_PATH . 'ajax-db-search.php');
        $this->assertStringNotContainsString(
            "LIKE '{\$_GET",
            $source,
            'ajax-db-search.php still interpolates $_GET directly into SQL'
        );
        $this->assertStringNotContainsString(
            "LIKE '\$_GET",
            $source,
            'ajax-db-search.php still interpolates $_GET directly into SQL'
        );
    }

    /** Must use a prepared statement */
    public function testAjaxSearchUsesPreparedStatement(): void {
        $source = file_get_contents(ROOT_PATH . 'ajax-db-search.php');
        $this->assertStringContainsString('prepare(', $source, 'No prepared statement found in ajax-db-search.php');
        $this->assertStringContainsString('bind_param', $source,  'No bind_param found in ajax-db-search.php');
    }

    /** Injection payload must not return extra data */
    public function testInjectionPayloadIsNeutralised(): void {
        // Connect to test DB
        $con = new mysqli('localhost', 'root', '', TEST_DB);
        if ($con->connect_error) { $this->markTestSkipped('Test DB not available'); }

        // A classic injection: term = "' OR '1'='1"
        $term   = "' OR '1'='1";
        $suffix = '%';
        $safe   = $term . $suffix;

        $stmt = $con->prepare(
            "SELECT Member_id FROM memberltdytd WHERE F_name LIKE ? LIMIT 5"
        );
        $stmt->bind_param('s', $safe);
        $stmt->execute();
        $result = $stmt->get_result();

        // With a prepared statement the LIKE value is treated as a literal string,
        // not SQL. It should match zero rows (no member named "' OR '1'='1%").
        $this->assertEquals(0, $result->num_rows,
            'Injection payload returned rows — prepared statement is not working correctly');
        $con->close();
    }

    /** Positive control: normal search still returns results */
    public function testNormalSearchStillWorks(): void {
        $con = new mysqli('localhost', 'root', '', TEST_DB);
        if ($con->connect_error) { $this->markTestSkipped('Test DB not available'); }
        // Insert a known test member
        $con->query("INSERT IGNORE INTO memberltdytd (Member_id, F_name, L_Name, Active)
                     VALUES ('TEST001', 'TestFirst', 'TestLast', NULL)");
        $term = 'TestFirst%';
        $stmt = $con->prepare("SELECT Member_id FROM memberltdytd WHERE F_name LIKE ?");
        $stmt->bind_param('s', $term);
        $stmt->execute();
        $this->assertGreaterThan(0, $stmt->get_result()->num_rows, 'Normal search returned no results');
        $con->query("DELETE FROM memberltdytd WHERE Member_id='TEST001'");
        $con->close();
    }
}
```

Run: `vendor/bin/phpunit tests/Security/SqlInjectionTest.php`
Expected: **testAjaxSearchHasNoRawInterpolation FAIL, testAjaxSearchUsesPreparedStatement FAIL** (red)

### 2.2 — Apply the Fix

Replace `ajax-db-search.php` with the parameterized version:

```php
<?php
header('Content-Type: application/json; charset=UTF-8');
include "config.php";

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if (isset($_GET['term'])) {
    $term = trim($_GET['term']) . '%';

    $stmt = $con->prepare(
        "SELECT Zip, FirstSal, SpouseSal, Member_id,
                CONCAT(F_Name, ' ', L_Name)           AS Name,
                CONCAT(Sp_FName, ' ', Sp_LName)       AS Spouse,
                CONCAT(Address1, ' ', Address2, ' ', Address3) AS Address
         FROM memberltdytd
         WHERE (F_name   LIKE ?
             OR L_Name   LIKE ?
             OR Zip      LIKE ?
             OR Sp_FName LIKE ?
             OR Sp_LName LIKE ?
             OR Member_id LIKE ?)
           AND (FirstSal != 'Late' OR SpouseSal != 'Late')
           AND (Active IS NULL OR Active = '')
         LIMIT 20"
    );
    $stmt->bind_param('ssssss', $term, $term, $term, $term, $term, $term);
    $stmt->execute();
    $result = $stmt->get_result();

    $memberData = [];
    while ($user = $result->fetch_assoc()) {
        $sp = $user['Spouse'] ?? '';
        if ($user['FirstSal'] === 'Late' || $user['SpouseSal'] === 'Late') {
            $value = $user['Name'];
        } elseif ($sp === '' || $sp === ' ') {
            $value = $user['Name'] . ' , ' . $user['Zip'];
        } else {
            $value = $user['Name'] . ' , ' . $sp . ' , ' . $user['Zip'];
        }
        $memberData[] = ['id' => $user['Member_id'], 'value' => $value];
    }

    echo json_encode($memberData);
}
```

Note: Also remove the `header('Access-Control-Allow-Origin: *');` line from this file — CORS is now controlled by `.htaccess` only (set in Phase 1).

### 2.3 — Verification

Run tests again: `vendor/bin/phpunit tests/Security/SqlInjectionTest.php`
Expected: **4 tests, 4 passed** (green)

**Manual check:**
- [ ] `http://localhost:8082/HDBS_Payment/pujaModule/ajax-db-search.php?term=a` — returns valid JSON member data
- [ ] `http://localhost:8082/HDBS_Payment/pujaModule/ajax-db-search.php?term=%27+OR+%271%27%3D%271` — returns empty `[]`, not all members
- [ ] Member lookup autocomplete on the front-end registration form still works

**Regression:** `vendor/bin/phpunit` — all Phase 1 tests still pass.

### Phase 2 — Done When
- [ ] All 4 SQL injection tests pass
- [ ] Injection payload returns empty array, not full member table
- [ ] Normal member search still works in the UI
- [ ] Git commit: `security(phase2): fix SQL injection in ajax-db-search.php — use prepared statements`

---

## Phase 3 — CSRF Protection

**Goal:** Every POST request in the application is protected by a token. One change to the base controller covers all 53+ controllers. Additional changes insert the hidden input into all view forms.

### 3.1 — Write Tests First (Red Phase)

Create `tests/Security/CsrfTest.php`:
```php
<?php
class CsrfTest extends PHPUnit\Framework\TestCase
{
    /** Base controller must validate a CSRF token on POST */
    public function testControllerHasCsrfValidation(): void {
        $source = file_get_contents(ROOT_PATH . 'core/framework/Controller.class.php');
        $this->assertStringContainsString('csrf_token', $source, 'No CSRF token logic in Controller.class.php');
        $this->assertStringContainsString('hash_equals', $source, 'No timing-safe comparison (hash_equals) in Controller.class.php');
    }

    /** Bootstrap or controller must generate a CSRF token */
    public function testCsrfTokenIsGenerated(): void {
        $source = file_get_contents(ROOT_PATH . 'core/bootstrap.php');
        $this->assertStringContainsString('csrf_token', $source, 'No CSRF token generation in bootstrap.php');
        $this->assertStringContainsString('random_bytes', $source, 'CSRF token not generated with random_bytes()');
    }

    /** Every POST form in views must include a csrf_token hidden field */
    public function testViewFormsContainCsrfToken(): void {
        $missingToken = [];
        $viewFiles = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(ROOT_PATH . 'application/views/')
        );
        foreach ($viewFiles as $file) {
            if ($file->getExtension() !== 'php') { continue; }
            $content = file_get_contents($file->getPathname());
            // Find any <form ... method="post"> (case-insensitive)
            if (preg_match('/<form[^>]+method=["\']?post["\']?/i', $content)) {
                if (!str_contains($content, 'csrf_token')) {
                    $missingToken[] = str_replace(ROOT_PATH, '', $file->getPathname());
                }
            }
        }
        $this->assertEmpty($missingToken,
            "POST forms missing csrf_token in:\n" . implode("\n", $missingToken));
    }

    /** Positive control — a properly escaped output should not trigger the XSS scanner */
    public function testTimingSafeComparisonIsUsed(): void {
        $source = file_get_contents(ROOT_PATH . 'core/framework/Controller.class.php');
        // Must NOT use simple === for token comparison
        $this->assertStringNotContainsString(
            "\$_POST['csrf_token'] ===",
            $source,
            'CSRF token compared with === instead of hash_equals()'
        );
    }
}
```

Run: `vendor/bin/phpunit tests/Security/CsrfTest.php` — expect **FAIL** (red).

### 3.2 — Apply the Fix

**Step A — Add token generation to `core/bootstrap.php`**

Find the Bootstrap class `init()` method and add at the very start, before the controller is instantiated:
```php
// CSRF token generation — runs on every request
if (session_status() === PHP_SESSION_ACTIVE && empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
```

**Step B — Add CSRF validation to `core/framework/Controller.class.php`**

Add to the `beforeFilter()` method:
```php
function beforeFilter() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $submitted = $_POST['csrf_token'] ?? '';
        $stored    = $_SESSION['csrf_token'] ?? '';
        if (!$stored || !hash_equals($stored, $submitted)) {
            http_response_code(403);
            exit('Invalid CSRF token. Please refresh the page and try again.');
        }
    }
}
```

**Step C — Add hidden CSRF field to all POST forms in views**

Use the automated tool from priestModule (adapt paths for pujaModule). If the tool is not available, run this script once:
```php
<?php
// tools/add-csrf-tokens.php — run once from command line
define('ROOT_PATH', dirname(__DIR__) . '/');
$viewDir = ROOT_PATH . 'application/views/';
$pattern = '/<form([^>]+)method=["\']?post["\']?([^>]*)>/i';
$replacement = '<form$1method="post"$2>' . PHP_EOL
    . '    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION[\'csrf_token\'] ?? \'\', ENT_QUOTES, \'UTF-8\') ?>">';

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewDir));
$count = 0;
foreach ($files as $file) {
    if ($file->getExtension() !== 'php') { continue; }
    $content = file_get_contents($file->getPathname());
    if (!preg_match($pattern, $content)) { continue; }
    // Only add if not already present
    if (str_contains($content, 'csrf_token')) { continue; }
    $new = preg_replace($pattern, $replacement, $content);
    file_put_contents($file->getPathname(), $new);
    echo "Updated: " . $file->getPathname() . PHP_EOL;
    $count++;
}
echo "Done. Updated $count files." . PHP_EOL;
```

Run: `php tools/add-csrf-tokens.php`

### 3.3 — Verification

Run: `vendor/bin/phpunit tests/Security/CsrfTest.php`
Expected: **4 tests, 4 passed** (green)

**Manual checks:**
- [ ] Admin login form submits successfully (CSRF token in session, hidden field in form, validation passes)
- [ ] Puja registration form submits successfully
- [ ] AJAX requests (autocomplete search, etc.) are not affected — these are GET requests, not POST
- [ ] For any AJAX that does POST: confirm the AJAX call sends the CSRF token (add `csrf_token: $('input[name=csrf_token]').val()` to AJAX data if needed)
- [ ] Try submitting a form with a tampered/missing token — must receive 403 error

**Regression:** `vendor/bin/phpunit` — all Phase 1 and 2 tests still pass.

### Phase 3 — Done When
- [ ] All 4 CSRF tests pass
- [ ] Login, registration, and payment forms submit without errors
- [ ] Forged POST returns 403
- [ ] Git commit: `security(phase3): add CSRF token protection to all POST forms`

---

## Phase 4 — XSS Output Escaping

**Goal:** All user-supplied data echoed into HTML is escaped with `htmlspecialchars()`. This is the highest-effort security phase due to the number of view files.

### 4.1 — Write Tests First (Red Phase)

Create `tests/Security/XssTest.php`:
```php
<?php
class XssTest extends PHPUnit\Framework\TestCase
{
    /** The h() helper function must exist */
    public function testEscapeHelperExists(): void {
        require_once ROOT_PATH . 'application/config/functions.inc.php';
        $this->assertTrue(function_exists('h'), 'h() helper function not found in functions.inc.php');
    }

    /** h() must correctly escape dangerous characters */
    public function testEscapeHelperWorks(): void {
        require_once ROOT_PATH . 'application/config/functions.inc.php';
        $this->assertEquals('&lt;script&gt;', h('<script>'));
        $this->assertEquals('&quot;', h('"'));
        $this->assertEquals('&#039;', h("'"));
    }

    /** The disabled XSS fix block must remain commented out (input escaping is wrong layer) */
    public function testOldXssBlockRemainsCommentedOut(): void {
        $source = file_get_contents(ROOT_PATH . 'index.php');
        // The old block used htmlentities on $_REQUEST — this must stay disabled
        // (we fix at output, not input)
        $this->assertStringNotContainsString(
            'isset($_REQUEST[$v]) and $_REQUEST[$v] = htmlentities',
            $source,
            'Old input-sanitization XSS block has been re-enabled — fix at output layer instead'
        );
    }

    /** Spot-check: Admin controller must not echo raw $_POST or $_GET values */
    public function testAdminControllerNoRawEcho(): void {
        $source = file_get_contents(ROOT_PATH . 'application/controllers/Admin.php');
        // Direct echo of superglobals into HTML is the danger pattern
        $this->assertDoesNotMatch(
            '/echo\s+\$_(?:GET|POST|REQUEST)\[/',
            $source,
            'Admin.php echoes a raw superglobal directly'
        );
    }
}
```

Run: `vendor/bin/phpunit tests/Security/XssTest.php` — expect **testEscapeHelperExists FAIL** (red).

### 4.2 — Apply the Fix

**Step A — Add `h()` helper to `application/config/functions.inc.php`**

Add at the top of the `Util` class (or as a standalone function before the class):
```php
/**
 * Safe HTML output escape. Use this everywhere a variable is echoed into HTML.
 */
function h($val): string {
    return htmlspecialchars((string)$val, ENT_QUOTES, 'UTF-8');
}
```

**Step B — Audit and fix all view files**

Work through each of the 39 view directories. The pattern to find and fix:

```bash
# Find echoes that likely need escaping (output to HTML context):
grep -rn "echo \$\|echo \$_\|<?= \$\|<?php echo \$" application/views/ | grep -v "csrf_token\|h(\|htmlspecialchars\|json_encode"
```

For each result, wrap the variable:
```php
// BEFORE:
echo $value['Member_id'];
echo "<td>" . $row['F_Name'] . "</td>";
echo "<input value='$user[email]'>";

// AFTER:
echo h($value['Member_id']);
echo "<td>" . h($row['F_Name']) . "</td>";
echo "<input value='" . h($user['email']) . "'>";
```

**Important exceptions — do NOT add `h()` to:**
- `echo json_encode(...)` — JSON output
- `echo $csv_row` — CSV output
- `header(...)` calls
- JavaScript variable assignments in `<script>` tags — these need `json_encode()`, not `h()`

**Step C — Work through controllers**

```bash
# Find echo in controllers that output HTML (not JSON/CSV):
grep -rn "echo \$\|echo \$_" application/controllers/ | grep -v "json_encode\|header(\|exit("
```

Fix confirmed HTML-context echoes in the same way.

### 4.3 — Verification

Run: `vendor/bin/phpunit tests/Security/XssTest.php`
Expected: **4 tests, 4 passed** (green)

**Manual checks:**
- [ ] Open member edit page — member name with `<b>test</b>` in name field should show as literal `<b>test</b>` not bold
- [ ] Open admin dashboard — no visual corruption of any data display
- [ ] Run registration form — values entered in fields display correctly after submission
- [ ] JSON AJAX responses are still valid JSON (not HTML-escaped)
- [ ] CSV exports are not corrupted

**Regression:** `vendor/bin/phpunit` — all Phase 1, 2, 3 tests still pass.

### Phase 4 — Done When
- [ ] `h()` helper exists and tests pass
- [ ] No raw `echo $_GET`/`echo $_POST` patterns remain in controllers (grep returns nothing)
- [ ] All view files with HTML context echoes use `h()`
- [ ] Visual spot-check of all major pages shows correct display
- [ ] Git commit: `security(phase4): add h() helper and apply XSS output escaping across all views`

---

## Phase 5 — Remaining Security Items

**Goal:** All remaining medium-priority security items. These are mostly single-file or small, isolated changes.

### 5.1 — Fix Error Reporting Configuration

**`application/config/config.php`** — remove `error_reporting(0)`:
```php
// DELETE this line:
error_reporting(0);
```

**`index.php`** — remove the temporary dev override added in Phase 0 and replace with env-aware config:
```php
// Replace the top of index.php with:
$env = getenv('APP_ENV') ?: 'production';
if ($env === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
    ini_set('error_log', ROOT_PATH . '../php-errors.log'); // outside web root
}
// Remove: ini_set("display_errors", "On");
```

Also remove `@` from `session_name()` and `session_start()` in `index.php`.

### 5.2 — Replace Weak Random Number Generation

**`core/framework/Controller.class.php`** — fix `getRandomPassword()`:
```php
function getRandomPassword($n = 6, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'): string {
    $m = strlen($chars) - 1;
    $result = '';
    while ($n--) {
        $result .= $chars[random_int(0, $m)];
    }
    return $result;
}
```

Also audit `Util::random_password()` and `Util::incrementalHash()` in `functions.inc.php` — replace any `rand()` / `srand()` used for security purposes with `random_int()` / `random_bytes()`.

### 5.3 — Fix File Upload Validation in Badges Controller

**`application/controllers/Badges.php`** — find the CSV import action and add before processing:
```php
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime  = finfo_file($finfo, $_FILES['csv_file']['tmp_name']);
finfo_close($finfo);

$allowedMimes = ['text/plain', 'text/csv', 'application/csv', 'application/vnd.ms-excel'];
if (!in_array($mime, $allowedMimes, true)) {
    // return error — do not process
    $this->tpl['error'] = 'Invalid file type. Only CSV files are accepted.';
    return;
}
```

### 5.4 — Replace Hardcoded localhost URLs

**`application/config/constants.php`** — make `INSTALL_URL` environment-driven:
```php
if (!defined("INSTALL_URL")) {
    define("INSTALL_URL", getenv('APP_URL') ?: "http://localhost:8082/HDBS_Payment/pujaModule/");
}
if (!defined("INSTALL_PATH")) {
    define("INSTALL_PATH", getenv('APP_PATH') ?: "C:/xampp/htdocs/HDBS_Payment/pujaModule/");
}
```

Then grep for all remaining hardcoded localhost references:
```bash
grep -rn "http://localhost:8082/HDBS_Payment" application/controllers/ application/views/ application/models/
```
Replace each with `INSTALL_URL . 'path'`.

### 5.5 — Fix Upload Permissions

**`application/helpers/uploader/class.upload.php`** — find `chmod(0777` and change to `chmod(0644`:
```php
// BEFORE:
chmod($file, 0777);
// AFTER:
chmod($file, 0644);
```

### 5.6 — Add Rate Limiting

Create the `login_attempts` table (add `update_db_11.sql` to `application/config/`):
```sql
CREATE TABLE IF NOT EXISTS login_attempts (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    action       VARCHAR(50)  NOT NULL,
    identifier   VARCHAR(255) NOT NULL,
    attempted_at DATETIME     NOT NULL,
    INDEX idx_rate (action, identifier, attempted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

Add a `RateLimit` class to `functions.inc.php` (see priestModule implementation) and apply it to:
- `Admin.php` — login POST block
- `PujaOnlinePayments.php` — payment submission
- `PujaDonations.php` — donation submission

### 5.7 — Verification

Create `tests/Security/Phase5Test.php`:
```php
<?php
class Phase5Test extends PHPUnit\Framework\TestCase
{
    public function testErrorReportingNotSuppressed(): void {
        $source = file_get_contents(ROOT_PATH . 'application/config/config.php');
        $this->assertStringNotContainsString('error_reporting(0)', $source,
            'error_reporting(0) still present in config.php');
    }

    public function testControllerUsesRandomInt(): void {
        $source = file_get_contents(ROOT_PATH . 'core/framework/Controller.class.php');
        $this->assertStringNotContainsString('srand(', $source,  'srand() still in Controller.class.php');
        $this->assertStringNotContainsString('rand()',  $source, 'rand() still in Controller.class.php');
        $this->assertStringContainsString('random_int(', $source, 'random_int() not found in Controller.class.php');
    }

    public function testUploadHandlerNotChmod777(): void {
        $source = file_get_contents(ROOT_PATH . 'application/helpers/uploader/class.upload.php');
        $this->assertStringNotContainsString('chmod(0777', $source, 'chmod(0777) still in uploader');
        $this->assertStringNotContainsString('chmod($', $source . '0777', 'chmod with 0777 found in uploader');
    }

    public function testInstallUrlUsesEnvOrDefault(): void {
        $source = file_get_contents(ROOT_PATH . 'application/config/constants.php');
        $this->assertStringContainsString('getenv(', $source, 'INSTALL_URL not driven by getenv() in constants.php');
    }
}
```

Run: `vendor/bin/phpunit tests/Security/Phase5Test.php`

**Manual checks:**
- [ ] CSV upload in Badges with a `.php` file disguised as CSV → rejected with error message
- [ ] CSV upload with a real CSV → accepted and imported
- [ ] Login page still works after rate limiter added
- [ ] After 5 failed logins, account is temporarily blocked
- [ ] Regression: `vendor/bin/phpunit` — all prior tests still pass

### Phase 5 — Done When
- [ ] All Phase 5 automated tests pass
- [ ] No `error_reporting(0)`, `srand()`, `rand()`, `chmod(0777)` remain in key files
- [ ] INSTALL_URL driven by environment variable
- [ ] Rate limiting active on login endpoint
- [ ] Git commit: `security(phase5): fix error config, weak rand, upload validation, rate limiting, localhost URLs`

---

## Phase 6 — Library Upgrades (PHPMailer, mPDF, Twilio)

**Goal:** Replace the three PHP 8-incompatible bundled libraries with Composer-managed versions. The application must still be on PHP 7.4 when this phase starts — these libraries need to work on both versions during the transition.

### 6.1 — Write Tests First (Red Phase)

Create `tests/Php8/LibraryTest.php`:
```php
<?php
class LibraryTest extends PHPUnit\Framework\TestCase
{
    /** PHPMailer must be loaded via Composer autoload, not the bundled file */
    public function testPhpMailerLoadedFromComposer(): void {
        $this->assertFileExists(ROOT_PATH . 'vendor/phpmailer/phpmailer/src/PHPMailer.php',
            'PHPMailer 6.x not found in vendor/');
        $this->assertDirectoryDoesNotExist(ROOT_PATH . 'application/helpers/PHPMailer_5.2.4',
            'Old PHPMailer 5.2.4 directory still exists');
    }

    /** mPDF must be loaded via Composer autoload */
    public function testMpdfLoadedFromComposer(): void {
        $this->assertFileExists(ROOT_PATH . 'vendor/mpdf/mpdf/src/Mpdf.php',
            'mPDF 8.x not found in vendor/');
        $this->assertDirectoryDoesNotExist(ROOT_PATH . 'application/helpers/MPDF57',
            'Old MPDF57 directory still exists');
    }

    /** No controller should still reference the old PHPMailer path */
    public function testNoOldPhpMailerReferences(): void {
        $results = [];
        $files = glob(ROOT_PATH . 'application/controllers/*.php');
        foreach ($files as $f) {
            if (str_contains(file_get_contents($f), 'PHPMailer_5.2.4')) {
                $results[] = basename($f);
            }
        }
        $this->assertEmpty($results, 'Old PHPMailer path still referenced in: ' . implode(', ', $results));
    }

    /** No controller should still reference the old mPDF path */
    public function testNoOldMpdfReferences(): void {
        $results = [];
        $files = glob(ROOT_PATH . 'application/controllers/*.php');
        foreach ($files as $f) {
            if (str_contains(file_get_contents($f), 'MPDF57')) {
                $results[] = basename($f);
            }
        }
        $this->assertEmpty($results, 'Old MPDF57 path still referenced in: ' . implode(', ', $results));
    }

    /** Twilio SDK version must be 8.x */
    public function testTwilioSdkVersion8(): void {
        $lock = json_decode(file_get_contents(ROOT_PATH . 'application/controllers/Twillio/composer.lock'), true);
        $version = null;
        foreach ($lock['packages'] as $pkg) {
            if ($pkg['name'] === 'twilio/sdk') {
                $version = $pkg['version'];
                break;
            }
        }
        $this->assertNotNull($version, 'twilio/sdk not found in Twillio/composer.lock');
        $this->assertStringStartsWith('8.', $version, "Twilio SDK is $version, expected 8.x");
    }
}
```

Run: expect all **FAIL** (red).

### 6.2 — Upgrade PHPMailer

**Step A — Add to root `composer.json`:**
```json
{
    "require": {
        "phpmailer/phpmailer": "^6.0",
        "mpdf/mpdf": "^8.0"
    },
    "require-dev": {
        "phpunit/phpunit": "^10.0"
    }
}
```
Run `composer install`.

**Step B — Add Composer autoloader to `index.php`**

Near the top of `index.php`, before the `require_once` of `config.php`:
```php
if (file_exists(ROOT_PATH . 'vendor/autoload.php')) {
    require_once ROOT_PATH . 'vendor/autoload.php';
}
```

**Step C — Update `App.php` and `Invoice.php`**

For each of the 15 PHPMailer usage locations in `App.php` and the 1 in `Invoice.php`:

1. Remove: `require_once APP_PATH . '/helpers/PHPMailer_5.2.4/class.phpmailer.php';`
2. Add at the top of the file (once, not 15 times):
   ```php
   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\SMTP;
   use PHPMailer\PHPMailer\Exception as PHPMailerException;
   ```
3. Replace `new PHPMailer()` → `new PHPMailer(true)` (the `true` enables exceptions)
4. Replace `catch (phpmailerException` → `catch (PHPMailerException`

**Step D — Update `Foodcoupon.php` mPDF usage**
```php
// REMOVE:
include_once (APP_PATH . "helpers/MPDF57/mpdf.php");
$mpdf = new mPDF();

// REPLACE WITH:
// (autoloaded — no include needed)
$mpdf = new \Mpdf\Mpdf();
```

**Step E — Delete old library directories:**
```bash
rm -rf application/helpers/PHPMailer_5.2.4
rm -rf application/helpers/MPDF57
```

**Step F — Upgrade Twilio:**
```bash
cd application/controllers/Twillio
# Edit composer.json: change "twilio/sdk": "^6.35" to "twilio/sdk": "^8.0"
composer update
```

### 6.3 — Verification

Run: `vendor/bin/phpunit tests/Php8/LibraryTest.php`
Expected: **5 tests, 5 passed** (green)

**Manual checks:**
- [ ] Trigger an email send (admin password reset or puja confirmation) — email is received
- [ ] Generate a food coupon PDF — PDF downloads correctly
- [ ] Test Twilio SMS OTP if the SMS feature is in use — SMS is received
- [ ] Regression: `vendor/bin/phpunit` — all prior tests still pass

### Phase 6 — Done When
- [ ] All 5 library tests pass
- [ ] PHPMailer 5.2.4 directory deleted
- [ ] MPDF57 directory deleted
- [ ] Email sending works
- [ ] PDF generation works
- [ ] Twilio at v8.x
- [ ] Git commit: `migration(phase6): upgrade PHPMailer to v6, mPDF to v8, Twilio to v8 via Composer`

---

## Phase 7 — Core Framework PHP 8.2 Fixes

**Goal:** Fix all PHP 8.2 issues in the core framework files. These are foundational — fixing them first means the rest of the app benefits automatically. Still running on PHP 7.4 at this point.

### 7.1 — Write Tests First (Red Phase)

Create `tests/Php8/FrameworkCompatTest.php`:
```php
<?php
class FrameworkCompatTest extends PHPUnit\Framework\TestCase
{
    /** Object.class.php must not use mysql_* functions */
    public function testNoMysqlFunctions(): void {
        $source = file_get_contents(ROOT_PATH . 'core/framework/Object.class.php');
        $this->assertStringNotContainsString('mysql_query(',     $source, 'mysql_query() found in Object.class.php');
        $this->assertStringNotContainsString('mysql_fetch_assoc', $source, 'mysql_fetch_assoc() found in Object.class.php');
    }

    /** Stripe helpers must use {$var} not ${var} interpolation */
    public function testStripeHelperInterpolation(): void {
        $files = [
            ROOT_PATH . 'application/helpers/stripe/lib/Stripe/SingletonApiResource.php',
            ROOT_PATH . 'application/helpers/stripe/lib/Stripe/ApiResource.php',
        ];
        foreach ($files as $file) {
            $source = file_get_contents($file);
            $this->assertStringNotContainsString('${', $source,
                "Deprecated \${var} interpolation found in " . basename($file));
        }
    }

    /** BaseQuery must have ReturnTypeWillChange attribute on getIterator */
    public function testBaseQueryReturnTypeAttribute(): void {
        $source = file_get_contents(ROOT_PATH . 'core/framework/BaseQuery.php');
        $this->assertStringContainsString('ReturnTypeWillChange', $source,
            'Missing #[ReturnTypeWillChange] on BaseQuery::getIterator()');
    }

    /** strpos checks must use !== false */
    public function testStrposNotFalse(): void {
        $source = file_get_contents(ROOT_PATH . 'core/framework/CommonQuery.php');
        // Should not have bare strpos() as the only condition (truthy check fails at position 0)
        $this->assertStringNotContainsString('if (strpos(', $source,
            'Bare strpos() truthiness check in CommonQuery.php — add !== false');
    }

    /** KCFinder must not check safe_mode */
    public function testNoSafeModeCheck(): void {
        $source = file_get_contents(ROOT_PATH . 'core/libs/kcfinder/core/bootstrap.php');
        $this->assertStringNotContainsString('ini_get("safe_mode")', $source,
            'safe_mode ini check still present in KCFinder bootstrap');
    }
}
```

Run: expect **FAIL** on multiple tests (red).

### 7.2 — Apply the Fixes

**`core/framework/Object.class.php`** — replace `mysql_*` calls:
```php
// BEFORE:
$r   = mysql_query("SELECT MAX(`order`) AS `max` FROM `$table` WHERE 1=1 $sql_conditions");
$row = mysql_fetch_assoc($r);

// AFTER (using global $con or pass as parameter — check how other methods connect):
// Option A: If $con is a global mysqli connection:
global $con;
$result = mysqli_query($con, "SELECT MAX(`order`) AS `max` FROM `$table` WHERE 1=1 $sql_conditions");
$row    = mysqli_fetch_assoc($result);
// NOTE: Also check if _getNextOrder is still called anywhere — it may be dead code
```

**`application/helpers/stripe/lib/Stripe/SingletonApiResource.php` line 19:**
```php
// BEFORE:
return "/v1/${base}";
// AFTER:
return "/v1/{$base}";
```

**`application/helpers/stripe/lib/Stripe/ApiResource.php` line 56:**
```php
// BEFORE:
return "/v1/${base}s";
// AFTER:
return "/v1/{$base}s";
```

**`core/framework/BaseQuery.php`** — add `ReturnTypeWillChange` attribute:
```php
/** @return PDOStatement */
#[\ReturnTypeWillChange]
public function getIterator() {
    return $this->execute();
}
```

**`core/framework/SelectQuery.php`** — add `ReturnTypeWillChange` attribute on `count()`:
```php
#[\ReturnTypeWillChange]
public function count() {
    // existing implementation
}
```

**`core/framework/CommonQuery.php`** — fix `strpos` comparisons:
```php
// BEFORE:
if (strpos($col, ' ') || strpos($col, '.'))
// AFTER:
if (strpos($col, ' ') !== false || strpos($col, '.') !== false)
```

**`core/framework/Model.class.php`** — fix `strpos`:
```php
// BEFORE:
if (strpos($column, ' '))
// AFTER:
if (strpos($column, ' ') !== false)
```

**`core/libs/kcfinder/core/bootstrap.php`** — remove `safe_mode` check:
```php
// REMOVE or comment out:
if (ini_get("safe_mode")) die(...);
```

**`application/helpers/stripe/lib/Stripe/Object.php`** — add `ReturnTypeWillChange` to all 4 ArrayAccess methods:
```php
#[\ReturnTypeWillChange]
public function offsetSet($k, $v) { ... }

#[\ReturnTypeWillChange]
public function offsetExists($k) { ... }
// etc.
```

### 7.3 — Verification

Run: `vendor/bin/phpunit tests/Php8/FrameworkCompatTest.php`
Expected: **5 tests, 5 passed** (green)

**Regression:** `vendor/bin/phpunit` — all prior tests still pass.

### Phase 7 — Done When
- [ ] All 5 framework compat tests pass
- [ ] No `mysql_*`, `${var}`, bare `strpos()`, `safe_mode` remaining in framework files
- [ ] Git commit: `migration(phase7): fix PHP 8.2 compat in core framework — mysql_, interpolation, ReturnTypeWillChange`

---

## Phase 8 — Controller-wide PHP 8.2 Fixes

**Goal:** Apply the two widespread patterns that affect all 53+ controllers: dynamic property declarations and timezone null guards. Use automated tools.

### 8.1 — Write Tests First (Red Phase)

Create `tests/Php8/ControllerCompatTest.php`:
```php
<?php
class ControllerCompatTest extends PHPUnit\Framework\TestCase
{
    /** All controllers that set $this->option_arr must declare it */
    public function testDynamicOptionArrDeclared(): void {
        $missing = [];
        foreach (glob(ROOT_PATH . 'application/controllers/*.php') as $file) {
            $source = file_get_contents($file);
            if (!str_contains($source, '$this->option_arr')) { continue; }
            // Class body must have "var $option_arr" or "public $option_arr"
            if (!preg_match('/(?:var|public|protected|private)\s+\$option_arr/', $source)) {
                $missing[] = basename($file);
            }
        }
        $this->assertEmpty($missing,
            "Controllers missing 'var \$option_arr' declaration:\n" . implode("\n", $missing));
    }

    /** date_default_timezone_set must not receive null */
    public function testTimezoneNullGuard(): void {
        $unguarded = [];
        foreach (glob(ROOT_PATH . 'application/controllers/*.php') as $file) {
            $source = file_get_contents($file);
            if (!str_contains($source, 'date_default_timezone_set')) { continue; }
            // Must have a null guard before the call
            if (!str_contains($source, "?? ''") && !str_contains($source, '?? "')) {
                $unguarded[] = basename($file);
            }
        }
        $this->assertEmpty($unguarded,
            "Controllers with unguarded date_default_timezone_set:\n" . implode("\n", $unguarded));
    }
}
```

Run: expect **FAIL** (red).

### 8.2 — Apply the Fixes

**Run the automated tool from priestModule** (adapt for pujaModule paths):

**Tool A — `tools/fix-dynamic-option-arr.php`:**
Scans every controller, finds the class declaration, inserts `var $option_arr = null;` in the class body if the controller uses `$this->option_arr` but does not yet declare it.

**Tool B — `tools/fix-timezone-null-guard.php`:**
Scans every controller for `date_default_timezone_set(...)`, wraps the argument with `?? ''` if not already present.

Run both tools:
```bash
php tools/fix-dynamic-option-arr.php
php tools/fix-timezone-null-guard.php
```

Review the diff carefully before committing — automated tools can occasionally produce unexpected output. Manually inspect any file flagged as changed.

### 8.3 — Verification

Run: `vendor/bin/phpunit tests/Php8/ControllerCompatTest.php`
Expected: **2 tests, 2 passed** (green)

**Manual spot-check:**
- [ ] Admin dashboard loads without deprecated property warnings in the error log
- [ ] Timezone-related date display is correct on registration and payment pages
- [ ] Regression: `vendor/bin/phpunit` — all prior tests still pass

### Phase 8 — Done When
- [ ] Both controller compat tests pass
- [ ] No `Creation of dynamic property` deprecation warnings in error log
- [ ] No `Passing null to date_default_timezone_set` deprecation warnings
- [ ] Git commit: `migration(phase8): declare option_arr in all controllers, add timezone null guards`

---

## Phase 9 — PHP 8.2 Switch & Full Regression

**Goal:** Switch the environment to PHP 8.2, watch the error log, fix any remaining runtime issues, run the full test suite, and do a complete manual regression across all major workflows.

### 9.1 — Pre-Switch Checklist
- [ ] All phases 1–8 committed and tests green
- [ ] Full database backup taken
- [ ] A known-good rollback commit identified (`git log --oneline -10`)
- [ ] Tell any other developers: the environment is switching

### 9.2 — Switch PHP Version

In XAMPP: switch the active PHP from 7.4 to 8.2 in `httpd.conf` or the XAMPP control panel. Restart Apache.

Verify the switch:
```bash
php --version   # should show PHP 8.2.x
```

### 9.3 — Monitor Error Log Immediately

```bash
tail -f C:/xampp82/apache/logs/error.log
```

Open the application and click through several pages. Common errors to expect and fix:

| Error Pattern | File(s) | Fix |
|---|---|---|
| `Undefined array key 0` | Models, controllers | Add `?? null` to `$arr[0]` accesses |
| `Deprecated: Creation of dynamic property ClassName::$foo` | Any controller missed by the tool | Add `var $foo = null;` to class |
| `Deprecated: date_default_timezone_set(): Passing null` | Any controller missed by the tool | Add `?? ''` guard |
| `TypeError: str_replace(): Argument #3 must be of type string, null given` | `functions.inc.php` or controllers | Add `?? ''` to third argument |
| `Fatal: Cannot access offset of type string on string` | Calendar, booking code | Check `ksort()` calls with `strtotime()` returning `false` |
| `Deprecated: ${var} string interpolation` | Any view files with JS template literals that PHP parses | These are PHP strings — change `${x}` to `{$x}` |
| `PDOException: SQLSTATE[HY000]` (new) | `BaseQuery.php` | PHP 8 PDO throws by default — wrap `execute()` in try/catch if not done |

Fix each error as it appears, adding it to the `tests/Php8/RuntimeTest.php` test file so it is captured.

### 9.4 — Full Test Suite Run

```bash
vendor/bin/phpunit
```

All tests across all phases must be green before proceeding to manual regression.

### 9.5 — Manual Regression

Work through the complete testing checklist from `master-remediation-guide.md` Section 6. Test every workflow:

**Authentication & Admin**
- [ ] Admin login (correct password → dashboard, wrong password → error, 6th attempt → rate limited)
- [ ] Password reset flow end-to-end (email received with link, link works, password changed)
- [ ] Each role type can access what it should and is blocked from what it should not

**Puja Registration**
- [ ] Early registration — complete flow (member lookup → form fill → payment → confirmation email)
- [ ] Regular registration — complete flow
- [ ] Registration status lookup
- [ ] PujaSankalpa registration
- [ ] PujaCart workflow

**Payments**
- [ ] Stripe payment (use Stripe test card `4242 4242 4242 4242`)
- [ ] Authorize.Net payment (if in use — skip if deferred)
- [ ] Puja donation
- [ ] Discount code application
- [ ] Associate payments and holds

**Tickets & Passes**
- [ ] PujaTicket purchase and redemption
- [ ] PujaPaidpasses
- [ ] PujaPassesadmin management

**Food Coupons & Parking**
- [ ] Food coupon purchase, PDF generation, redemption
- [ ] Paid parking registration
- [ ] Parking admin view

**Badges**
- [ ] Badge CSV import (valid CSV accepted, invalid MIME rejected)
- [ ] Badge report PDF generation (mPDF 8)

**Communication**
- [ ] Email send via PHPMailer 6 — puja confirmation email
- [ ] PujaMagazine subscription

**Booking**
- [ ] GzFront priest booking — full slot selection to payment flow
- [ ] Calendar admin management

**Member & Utility**
- [ ] Member registration and edit
- [ ] Member lookup autocomplete
- [ ] Statistics page

### 9.6 — Final Commit

```bash
git commit -m "migration(phase9): switch to PHP 8.2 — all runtime errors fixed, full regression passed"
```

### Phase 9 — Done When
- [ ] PHP 8.2 active, no fatal errors in error log during normal use
- [ ] Full PHPUnit test suite green
- [ ] All manual regression checklist items checked
- [ ] No deprecation warnings in error log during normal use (warnings allowed to remain only in vendor/ code not yet upgraded)
- [ ] Git commit created

---

## Phase 10 — PHP 8.4 Upgrade

**Goal:** Move from PHP 8.2 to PHP 8.4 (current stable). Must be completed before December 2026 when PHP 8.2 security support ends.

**Prerequisite:** Phase 9 complete and the application is stable on PHP 8.2.

### What Changed Between 8.2 and 8.4

**PHP 8.3 additions (no breaking changes expected for this codebase):**
- `json_validate()` function added — no action needed
- `#[Override]` attribute added — no action needed
- Typed class constants — no action needed (no new requirement, just opt-in)
- Dynamic class constant fetch `$class::$const` — no action needed

**PHP 8.4 additions to watch:**
- `array_find()`, `array_find_key()` — new functions, no conflict unless you have a custom function with the same name. Check with: `grep -rn "function array_find" application/`
- Property hooks (new syntax) — no action needed, opt-in only
- Deprecations to check:
  - `E_STRICT` constant removed — check if any code references it
  - Implicitly nullable parameters `function foo(Type $x = null)` — must become `function foo(?Type $x = null)`. Run a grep across all models and controllers
  - `_` as a standalone identifier deprecated further — unlikely to affect this codebase

### 10.1 — Write Tests First (Red Phase)

Create `tests/Php8/Php84CompatTest.php`:
```php
<?php
class Php84CompatTest extends PHPUnit\Framework\TestCase
{
    /** No custom array_find function that would conflict with PHP 8.4 built-in */
    public function testNoConflictingArrayFind(): void {
        $matches = [];
        foreach (glob(ROOT_PATH . 'application/{controllers,models,config}/*.php', GLOB_BRACE) as $file) {
            if (preg_match('/function\s+array_find\s*\(/', file_get_contents($file))) {
                $matches[] = basename($file);
            }
        }
        $this->assertEmpty($matches, 'Custom array_find() conflicts with PHP 8.4 built-in: ' . implode(', ', $matches));
    }

    /** Implicitly nullable parameters must be explicit */
    public function testNoImplicitNullableParams(): void {
        $violations = [];
        $dirs = [ROOT_PATH . 'core/framework/', ROOT_PATH . 'application/models/'];
        foreach ($dirs as $dir) {
            foreach (glob($dir . '*.php') as $file) {
                // Pattern: function foo(SomeType $x = null) — missing ?
                if (preg_match('/function\s+\w+\([^)]*[A-Z]\w+\s+\$\w+\s*=\s*null/', file_get_contents($file))) {
                    $violations[] = basename($file);
                }
            }
        }
        $this->assertEmpty($violations,
            "Implicitly nullable parameters (need '?Type') in:\n" . implode("\n", $violations));
    }

    /** PHP version must be 8.4.x */
    public function testPhpVersion84(): void {
        $this->assertGreaterThanOrEqual(
            80400,
            PHP_VERSION_ID,
            'PHP version is ' . PHP_VERSION . ', expected 8.4.x or higher'
        );
    }
}
```

### 10.2 — Apply the Fixes

1. Install PHP 8.4 XAMPP or update the PHP binary
2. Run `vendor/bin/phpunit tests/Php8/Php84CompatTest.php` — fix any failures
3. Fix any implicitly nullable parameters found by the test:
   ```php
   // BEFORE (deprecated in 8.4):
   function getBooking(Booking $booking = null) { ... }
   // AFTER:
   function getBooking(?Booking $booking = null) { ... }
   ```
4. Switch Apache to use PHP 8.4 and restart

### 10.3 — Smoke Test

Open in browser and confirm no new errors in error log:
- [ ] Admin login
- [ ] Registration form
- [ ] Payment flow (Stripe test mode)
- [ ] Email send
- [ ] PDF generation

Run: `vendor/bin/phpunit` — all tests green.

### Phase 10 — Done When
- [ ] Running PHP 8.4.x (confirmed by `phpinfo()`)
- [ ] All automated tests pass
- [ ] No new errors or deprecation warnings in error log
- [ ] Smoke test pages load cleanly
- [ ] Git commit: `migration(phase10): upgrade to PHP 8.4`

---

## Deferred Work (Out of Scope for These Phases)

The following items are real but are deliberately excluded from this plan because they carry higher risk and/or require a dedicated sprint:

| Item | Reason Deferred |
|---|---|
| Authorize.Net SDK rewrite (`sdk-php-master/`) | Full rewrite of payment processing — too risky to combine with security/PHP migration work |
| Frontend upgrades (jQuery 1.9.1 → current, Bootstrap 3 → 5) | UI-impacting changes — requires separate QA cycle |
| PHPUnit integration tests with live DB for payment flows | Requires payment sandbox setup |
| Database field encryption for sensitive PII | Schema change — requires data migration |
| Move to a maintained framework (Laravel/Symfony) | Major architectural work |

---

## Quick Reference: Test Commands

```bash
# Run all tests:
vendor/bin/phpunit

# Run a single phase:
vendor/bin/phpunit tests/Security/Phase1Test.php
vendor/bin/phpunit tests/Security/SqlInjectionTest.php
vendor/bin/phpunit tests/Security/CsrfTest.php
vendor/bin/phpunit tests/Security/XssTest.php
vendor/bin/phpunit tests/Security/Phase5Test.php
vendor/bin/phpunit tests/Php8/LibraryTest.php
vendor/bin/phpunit tests/Php8/FrameworkCompatTest.php
vendor/bin/phpunit tests/Php8/ControllerCompatTest.php
vendor/bin/phpunit tests/Php8/Php84CompatTest.php

# Run only security suite:
vendor/bin/phpunit --testsuite Security

# Run only PHP 8 compat suite:
vendor/bin/phpunit --testsuite PHP8Compat

# Run with verbose output:
vendor/bin/phpunit --verbose

# Run and stop on first failure:
vendor/bin/phpunit --stop-on-failure
```

---

## Related Documents

- [`master-remediation-guide.md`](./master-remediation-guide.md) — Full vulnerability and migration details
- [`codebase-observations.md`](./codebase-observations.md) — Original audit
- [`security-remediation-plan.md`](./security-remediation-plan.md) — Original security steps
- [`php8-migration-plan.md`](./php8-migration-plan.md) — Original PHP migration steps
- [`test-results-red-phase.md`](./test-results-red-phase.md) — Security test baseline

---

_End of document._
