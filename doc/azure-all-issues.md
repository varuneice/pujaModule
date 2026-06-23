# HDBS Puja Module — All Issues for Azure Migration
_Created: 2026-03-19_

This is the single reference document covering every code issue, SQL issue, and SSL issue
that must be resolved before deploying to Azure Web App + Azure MySQL.

---

## Quick Status Table

| # | Category | Issue | Severity | Status |
|---|---|---|---|---|
| 1 | SSL | `CURLOPT_SSL_VERIFYPEER = false` in Stripe helper | 🔴 Critical | Needs fix |
| 2 | SSL | Azure MySQL requires SSL — no `ssl_set()` in connections | 🔴 Critical | Needs fix |
| 3 | SSL | IMAP Gmail password hardcoded in plaintext | 🔴 Critical | Needs fix |
| 4 | Code | `env.php` gitignored — won't exist on Azure | 🔴 Critical | Needs fix |
| 5 | Code | PHPMailer uses `mail()` — port 25 blocked on Azure | 🔴 Critical | Needs fix |
| 6 | Code | File uploads to local disk — ephemeral on Azure | 🔴 Critical | Needs fix |
| 7 | SQL | `0000-00-00` zero dates rejected by MySQL 8.0 strict mode | 🔴 Critical | Needs fix |
| 8 | SQL | `ONLY_FULL_GROUP_BY` violation in Donationnewview | 🔴 Critical | Needs fix |
| 9 | Code | Hardcoded `durgabari.org` URLs in email templates + PDF paths | 🟡 Medium | Needs fix |
| 10 | Code | Hardcoded `localhost:8082` in Admin.php JS redirect | 🟡 Medium | Needs fix |
| 11 | Code | `php_value max_execution_time 600` in `.htaccess` | 🟡 Medium | Needs fix |
| 12 | SQL | `DEFAULT CHARSET=utf8` in database.sql (14 tables) | 🟡 Medium | Minor — MySQL 8 auto-converts |
| 13 | Code | Twilio has its own `vendor/` directory (deployment) | 🟡 Medium | Already in git |
| 14 | Code | `db.php` reads only from `env.php`, not `getenv()` | 🟡 Medium | Needs fix |

---

## SSL Issues

---

### SSL-1 — `CURLOPT_SSL_VERIFYPEER = false` in Stripe Helper 🔴 Critical

**File:** `application/helpers/stripe/lib/Stripe/ApiRequestor.php` line 254

**What it does:**
```php
$opts[CURLOPT_SSL_VERIFYPEER] = false;
```

This disables SSL certificate verification on all outbound Stripe API calls. This means:
- The app will accept any certificate — including forged/expired ones
- A man-in-the-middle attacker could intercept payment API calls
- On Azure (which has a proper CA bundle), this is unnecessary and dangerous

**The fix:**
```php
// Remove the false line entirely, OR explicitly set to true:
$opts[CURLOPT_SSL_VERIFYPEER] = true;
// Azure Linux already has a valid CA bundle at /etc/ssl/certs/ca-certificates.crt
// No additional cainfo path needed on Azure
```

**Note:** This is in the old bundled Stripe helper (`application/helpers/stripe/`). The modern Stripe PHP SDK (installable via Composer) does not have this issue. Consider upgrading to `stripe/stripe-php` via Composer — same as PHPMailer and mPDF were upgraded.

---

### SSL-2 — Azure MySQL Requires SSL — No `ssl_set()` in Code 🔴 Critical

**Files:** `config.php`, `application/controllers/PujaDonations.php`, `application/controllers/GzFront.php`

**What the problem is:**
Azure Database for MySQL enforces SSL connections by default. Without SSL, the connection is **refused** with:
```
SSL connection error: SSL is required
```

**Current code (all 3 connection points):**
```php
$con = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
// No SSL — will be refused by Azure MySQL
```

**The fix — add SSL before connecting:**

Download the Azure MySQL SSL certificate:
- File: `DigiCertGlobalRootCA.crt.pem`
- Place it at: `application/config/ssl/DigiCertGlobalRootCA.crt.pem`

Then in each connection:
```php
// config.php
try {
    $con = new mysqli();
    $con->ssl_set(null, null, ROOT_PATH . 'application/config/ssl/DigiCertGlobalRootCA.crt.pem', null, null);
    $con->real_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, 3306, null, MYSQLI_CLIENT_SSL);
    $con->set_charset('utf8mb4');
} catch (\mysqli_sql_exception $e) {
    die("Connection failed: " . $e->getMessage());
}
```

Apply the same pattern to `PujaDonations.php` and `GzFront.php`.

**Alternative (simpler for Azure):** Disable SSL enforcement on the Azure MySQL Flexible Server:
- Portal → Azure Database for MySQL → Server Parameters → `require_secure_transport` → set to `OFF`
- Only acceptable for dev/test — **not recommended for production**

---

### SSL-3 — Gmail IMAP Password Hardcoded in Plaintext 🔴 Critical

**File:** `application/controllers/GzFront.php` lines 120 and 209

**What is in the code:**
```php
$conn = imap_open(
    '{imap.gmail.com:993/imap/ssl}INBOX',
    'treasurerpuja@durgabari.org',
    'ggtfnczdodeukgzp'   // ← Gmail app password committed in plaintext
) or die('Cannot connect to Gmail: ' . imap_last_error());
```

A Gmail account password (or app password) is committed directly in source code. Anyone with git access can see and use it.

**The fix:**
1. Move credentials to `env.php` and read via `getenv()`:
```php
// In env.php:
$ENV_IMAP_USER = 'treasurerpuja@durgabari.org';
$ENV_IMAP_PASS = 'ggtfnczdodeukgzp';

// In GzFront.php:
$imapUser = getenv('IMAP_USER') ?: ($ENV_IMAP_USER ?? '');
$imapPass = getenv('IMAP_PASS') ?: ($ENV_IMAP_PASS ?? '');
$conn = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', $imapUser, $imapPass)
    or die('Cannot connect to Gmail: ' . imap_last_error());
```

2. Add `IMAP_USER` and `IMAP_PASS` to Azure App Settings.

3. **Immediately rotate the Gmail password** — it is already in git history.

**Note on Azure:** `ext-imap` must be enabled on the Azure App Service PHP runtime. Check that it is available — it is not always enabled by default on Linux App Service.

---

## Code Issues

---

### CODE-1 — `env.php` Won't Exist on Azure 🔴 Critical

**File:** `application/config/db.php`

`env.php` is in `.gitignore` and will not be deployed. Without it, `db.php` calls `die()` immediately.

**The fix — update `db.php`:**
```php
// Try environment variables first (Azure App Settings), fall back to env.php if present
$_env_file = __DIR__ . '/env.php';
if (file_exists($_env_file)) {
    require_once $_env_file;
}
$DB_HOST = getenv('DB_HOST') ?: ($ENV_DB_HOST ?? null);
$DB_NAME = getenv('DB_NAME') ?: ($ENV_DB_NAME ?? null);
$DB_USER = getenv('DB_USER') ?: ($ENV_DB_USER ?? null);
$DB_PASS = getenv('DB_PASS') ?: ($ENV_DB_PASS ?? null);

if (!$DB_HOST || !$DB_NAME) {
    die('Missing DB configuration. Set DB_HOST, DB_NAME, DB_USER, DB_PASS in App Settings.');
}
```

**Azure App Settings to add:**

| Setting | Value |
|---|---|
| `DB_HOST` | `yourserver.mysql.database.azure.com` |
| `DB_NAME` | `durgab5_HDBS_Payment_Prod` |
| `DB_USER` | `hdbs_admin` |
| `DB_PASS` | `your-strong-password` |
| `APP_URL` | `https://yourdomain.azurewebsites.net/` |
| `APP_PATH` | `/home/site/wwwroot/` |
| `APP_ENV` | `production` |
| `IMAP_USER` | `treasurerpuja@durgabari.org` |
| `IMAP_PASS` | `new-app-password-after-rotation` |
| `MAIL_HOST` | `smtp.sendgrid.net` |
| `MAIL_USER` | `apikey` |
| `MAIL_PASS` | `your-sendgrid-api-key` |

---

### CODE-2 — PHPMailer Uses `mail()` — Port 25 Blocked on Azure 🔴 Critical

**File:** `application/controllers/App.php` (all email-sending methods)

Azure blocks all outbound connections on port 25. PHPMailer without `isSMTP()` falls back to PHP's `mail()` / sendmail which does not work on Azure.

**The fix — add SMTP config to each PHPMailer block in `App.php`:**
```php
$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host       = getenv('MAIL_HOST') ?: 'smtp.sendgrid.net';
$mail->SMTPAuth   = true;
$mail->Username   = getenv('MAIL_USER') ?: 'apikey';
$mail->Password   = getenv('MAIL_PASS') ?: '';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;
// ... rest of mail setup unchanged
```

There are **15+ PHPMailer blocks** in `App.php`. Extract the SMTP setup into a private helper method to avoid repeating it.

---

### CODE-3 — File Uploads Lost on Azure Restart 🔴 Critical

**Path:** `application/web/upload/` (avatar, invoice, image subdirectories)

Azure App Service local disk is reset on every deployment and app restart.

**Fix:** Mount an Azure File Share to `application/web/upload/` via Azure Portal:
- App Service → Configuration → Path mappings → Add Azure Storage Mount
- Account: your storage account
- Mount path: `/home/site/wwwroot/application/web/upload`
- No code changes required

---

### CODE-4 — Hardcoded `durgabari.org` URLs in Email Templates and PDF Paths 🟡 Medium

**Files:** `App.php` (~12 occurrences), `Foodcoupon.php` (2 occurrences)

Examples:
```php
// App.php — logo in email HTML
<img src="https://durgabari.org/HDBS_Payment/application/web/upload/image/create.png">

// App.php — domain for email links
$domain = 'https://durgabari.org/HDBS_Payment/Preview/index';

// App.php — esign path
$Path = "https://durgabari.org/HDBS_Payment_Parking_Badges/esign/";

// Foodcoupon.php — PDF download path
$path = 'https://durgabari.org/HDBS_PaymentTesting/parkinginvoice/Foodcoupon_...';
```

If deployed to Azure at a different URL these will point to the wrong server — email logos will be broken and PDF download links will 404.

**The fix:** Replace all hardcoded `durgabari.org` URLs with `INSTALL_URL`:
```php
// BEFORE
$domain = 'https://durgabari.org/HDBS_Payment/Preview/index';
<img src="https://durgabari.org/HDBS_Payment/application/web/upload/image/create.png">

// AFTER
$domain = INSTALL_URL . 'Preview/index';
<img src="' . INSTALL_URL . 'application/web/upload/image/create.png">
```

---

### CODE-5 — Hardcoded `localhost:8082` in Admin.php JS Redirect 🟡 Medium

**File:** `application/controllers/Admin.php` line 156

```php
document.location.href = 'http://localhost:8082/HDBS_Payment/pujaModule/Admin/login';
```

This is a JavaScript redirect inside a PHP-generated script block. On Azure this will redirect users to localhost instead of the live site.

**The fix:**
```php
document.location.href = '<?= h(INSTALL_URL) ?>Admin/login';
```

---

### CODE-6 — `php_value max_execution_time 600` in `.htaccess` 🟡 Medium

**File:** `.htaccess` last line

Azure App Service may not honor `php_value` directives in `.htaccess`.

**The fix:** Remove from `.htaccess` and create `.user.ini` in the project root:
```ini
max_execution_time = 600
memory_limit = 256M
upload_max_filesize = 20M
post_max_size = 20M
```

---

### CODE-7 — `db.php` Doesn't Check `getenv()` First 🟡 Medium

Already covered under CODE-1. The current `db.php` only reads from `env.php` — it must check `getenv()` first so Azure App Settings take priority.

---

## SQL Issues

---

### SQL-1 — `0000-00-00` Zero Dates Rejected by MySQL 8.0 Strict Mode 🔴 Critical

**Azure MySQL 8.0 default SQL mode includes:** `NO_ZERO_DATE`, `NO_ZERO_IN_DATE`

**Files affected:**

`application/models/ConfirmCode.model.php` — lines 25, 58, 73 (active queries):
```php
WHERE UpdatedOn="0000-00-00"   // ← rejected by strict mode
```

`application/controllers/BadgeReport.php` — line 66:
```php
if ($arr[0]['Date'] === '0000-00-00')  // ← reads zero date that may come back as NULL
```

**Three-step fix:**

**Step 1 — Fix queries:**
```php
// ConfirmCode.model.php — change all 3 occurrences:
WHERE UpdatedOn IS NULL
```

**Step 2 — Fix PHP code to handle NULL:**
```php
// BadgeReport.php
if (empty($arr[0]['Date']) || $arr[0]['Date'] === '0000-00-00')
```

**Step 3 — Clean the database before migrating:**
```sql
-- Run on XAMPP before exporting:
UPDATE confirm_code SET UpdatedOn = NULL WHERE UpdatedOn = '0000-00-00';
-- Repeat for any other table/column with zero dates
-- Run: SELECT table_name, column_name FROM information_schema.columns
--      WHERE table_schema='durgab5_HDBS_Payment_Prod'
--      AND data_type IN ('date','datetime') to find all date columns
```

**Step 4 — Fix the dump file:**
```bash
sed "s/'0000-00-00'/NULL/g" hdbs_export.sql > hdbs_export_fixed.sql
```

---

### SQL-2 — `ONLY_FULL_GROUP_BY` Violation 🔴 Critical

**File:** `application/models/Donationnewview.model.php` line 105

```php
$sql = 'SELECT donationnewview.id as ID,            ← not in GROUP BY, not aggregated
               donationnewview.pay_for AS MemberType,
               sum(donationnewview.Amount) AS Revenue
        ...
        GROUP BY MemberType';
```

MySQL 8.0 will throw: `ERROR 1055: Expression #1 of SELECT list is not in GROUP BY clause`

**The fix:**
```php
$sql = 'SELECT ANY_VALUE(donationnewview.id) as ID,
               donationnewview.pay_for AS MemberType,
               sum(donationnewview.Amount) AS Revenue
        ...
        GROUP BY donationnewview.pay_for';   // GROUP BY the actual column, not the alias
```

---

### SQL-3 — `DEFAULT CHARSET=utf8` in Schema 🟡 Medium

**File:** `application/config/database.sql` — 14 tables

```sql
) ENGINE=InnoDB DEFAULT CHARSET=utf8;   // ← should be utf8mb4
```

MySQL 8.0 aliases `utf8` to `utf8mb4` automatically so this will not break. However update for clarity:
```bash
sed -i 's/DEFAULT CHARSET=utf8;/DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;/g' application/config/database.sql
```

PHP connections already correctly use `utf8mb4` in all three connection points. ✅

---

## Summary — Fix Order for Azure Migration

Work through these in order:

**Do first (blockers — app won't work without these):**
1. `SSL-2` — Add `ssl_set()` for Azure MySQL connections
2. `CODE-1` + `CODE-7` — Update `db.php` to read `getenv()` first; set Azure App Settings
3. `SQL-1` — Fix zero dates in code + clean database dump
4. `SQL-2` — Fix `ONLY_FULL_GROUP_BY` in Donationnewview
5. `CODE-2` — Add `isSMTP()` + SMTP relay to PHPMailer
6. `CODE-3` — Mount Azure File Share for uploads

**Do before go-live (will cause incorrect behaviour):**

7. `SSL-1` — Fix `CURLOPT_SSL_VERIFYPEER = false` in Stripe helper
8. `SSL-3` — Move IMAP credentials to env vars + rotate Gmail password
9. `CODE-4` — Replace hardcoded `durgabari.org` URLs with `INSTALL_URL`
10. `CODE-5` — Fix `localhost:8082` JS redirect in Admin.php
11. `CODE-6` — Move `php_value` from `.htaccess` to `.user.ini`
12. `SQL-3` — Update `CHARSET=utf8` → `utf8mb4` in schema SQL

---

## What Does NOT Need Changing ✅

| Item | Reason |
|---|---|
| All security fixes (CSRF, XSS, SQL injection, rate limiting) | Code-level, environment-independent |
| PHPMailer 6.x / mPDF 8.x / Twilio 8.x | Composer-managed, works on Linux |
| `.htaccess` RewriteEngine / URL routing | Azure App Service uses Apache — mod_rewrite enabled |
| Stripe JS (`https://js.stripe.com/v3/`) | External CDN — no change needed |
| `DATE_FORMAT`, `CURDATE()`, `YEAR()`, MySQL functions | Identical in MySQL 8.0 |
| `InnoDB` engine, `AUTO_INCREMENT`, `LIMIT`, subqueries | All standard — fully compatible |
| Session handling (single instance) | File sessions work fine on single instance |
| PHP 8.2 compatibility (all phases 8–12 done) | Already fixed |

---

_End of document._
