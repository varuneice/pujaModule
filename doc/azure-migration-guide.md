# HDBS Puja Module — Azure Web App Migration Guide
_Created: 2026-03-19_

---

## 1. What Is Azure Web App (App Service)?

Azure App Service is a **fully managed PaaS** (Platform as a Service) hosting environment. You provide your code — Microsoft manages the server, OS patches, PHP runtime, and infrastructure.

| Concern | XAMPP (Local) | Azure App Service |
|---|---|---|
| Server setup | You manage Apache + PHP | Microsoft manages everything |
| PHP version | You install it | You pick it from a dropdown |
| OS | Windows | **Linux** (recommended for PHP) |
| Database | MySQL on same machine | Separate: Azure Database for MySQL |
| File storage | Local disk (permanent) | **Ephemeral by default** — see Section 3 |
| Email (port 25) | Open | **Blocked** — must use SMTP relay |
| Scaling | Single machine | Can scale to multiple instances |

**Recommended plan:** Azure App Service **Basic B2 or Standard S1** — these support custom domains, SSL, and always-on (prevents cold starts). Free/Shared tiers are for testing only.

---

## 2. Good News — What Works As-Is ✅

| Item | Why it works |
|---|---|
| **PHP 8.2** | Azure App Service on Linux supports PHP 8.2 natively |
| **mysqli** | Standard PHP extension — available on Azure |
| **Composer dependencies** (PHPMailer 6, mPDF 8, Twilio 8) | Azure can run `composer install` during deployment |
| **`.htaccess` + `mod_rewrite`** | Azure App Service (Linux/PHP) uses Apache — mod_rewrite is enabled |
| **Stripe payments** | HTTPS outbound calls — no restrictions |
| **CSRF, XSS, SQL injection fixes** | All code-level — no environment dependency |
| **Session handling (single instance)** | PHP file sessions work fine on a single instance |
| **mPDF PDF generation** | `ext-gd` is available on Azure PHP runtime |
| **Relative internal paths** | `APP_PATH`, `ROOT_PATH` all derived from `__FILE__` — work correctly on Linux |

---

## 3. Issues That Need Attention Before Going Live

---

### 🔴 Issue 1 — File Uploads: Ephemeral Storage (CRITICAL)

**The problem:**
Azure App Service's local filesystem (`/home/site/wwwroot/`) is **reset on every deployment and restart**. Any uploaded files written to:
```
application/web/upload/avatar/
application/web/upload/invoice/
application/web/upload/badges/
```
…will be **permanently lost** when the app restarts or a new deployment happens.

**The fix — two options:**

**Option A (Simpler): Azure Files Mount**
Mount an Azure Storage File Share to `/home/site/wwwroot/application/web/upload/`.
- Files persist permanently across deployments and restarts
- No code changes required — the path stays the same
- Set up in Azure Portal: App Service → Configuration → Path mappings

**Option B (Better long-term): Azure Blob Storage**
Store uploads in Azure Blob Storage and serve via CDN URL.
- Requires code changes in upload/download paths
- More scalable and cheaper at volume
- Recommended if the app grows

**Recommendation for now: Option A** — zero code changes, works immediately.

---

### 🔴 Issue 2 — `env.php` Not on Azure (CRITICAL)

**The problem:**
`application/config/env.php` is in `.gitignore` and will **not be deployed to Azure**. Without it, `db.php` calls `die()` and the app won't start.

**Current flow:**
```
env.php (gitignored) → db.php → constants.php + config.php
```

**The fix:**
Set all values as **Azure App Settings** (which become environment variables). Then update `db.php` to read from `getenv()` first:

```php
// application/config/db.php — Azure-ready version
$DB_HOST = getenv('DB_HOST') ?: ($ENV_DB_HOST ?? null);
$DB_NAME = getenv('DB_NAME') ?: ($ENV_DB_NAME ?? null);
$DB_USER = getenv('DB_USER') ?: ($ENV_DB_USER ?? null);
$DB_PASS = getenv('DB_PASS') ?: ($ENV_DB_PASS ?? null);

if (!$DB_HOST || !$DB_NAME) {
    die('Missing database configuration. Set DB_HOST, DB_NAME, DB_USER, DB_PASS in App Settings.');
}
```

**Azure App Settings to configure** (Portal → App Service → Configuration → Application settings):

| App Setting Name | Example Value |
|---|---|
| `DB_HOST` | `yourserver.mysql.database.azure.com` |
| `DB_NAME` | `durgab5_HDBS_Payment_Prod` |
| `DB_USER` | `hdbs_app@yourserver` |
| `DB_PASS` | `your-strong-password` |
| `APP_URL` | `https://yourdomain.azurewebsites.net/` |
| `APP_PATH` | `/home/site/wwwroot/` |
| `APP_ENV` | `production` |
| `APP_CORS_ORIGIN` | `https://yourdomain.azurewebsites.net` |

Also update `constants.php` to use `getenv()` for `INSTALL_URL` and `INSTALL_PATH`:
```php
// Already partially done — just ensure getenv() is checked FIRST:
define("INSTALL_PATH", getenv('APP_PATH') ?: ($ENV_APP_PATH ?? '/home/site/wwwroot/'));
define("INSTALL_URL",  getenv('APP_URL')  ?: ($ENV_APP_URL  ?? 'https://yourdomain.azurewebsites.net/'));
```

---

### 🔴 Issue 3 — Email: Port 25 Blocked (CRITICAL)

**The problem:**
Azure blocks all outbound connections on **port 25** (standard SMTP). The current PHPMailer setup uses PHP's internal `mail()` / sendmail function — this **will not work on Azure**.

**What the code currently does:**
```php
$mail = new PHPMailer(true);
// No $mail->isSMTP() call — uses PHP's mail() function
$mail->Send();
```

**The fix:**
Enable SMTP in PHPMailer and point it at an external mail relay. Azure recommends **SendGrid** (has a free tier of 25,000 emails/month):

```php
$mail->isSMTP();
$mail->Host       = getenv('MAIL_HOST') ?: 'smtp.sendgrid.net';
$mail->SMTPAuth   = true;
$mail->Username   = getenv('MAIL_USER') ?: 'apikey';
$mail->Password   = getenv('MAIL_PASS') ?: '';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;
```

Add to Azure App Settings:

| Setting | Value |
|---|---|
| `MAIL_HOST` | `smtp.sendgrid.net` (or Office 365 / Gmail) |
| `MAIL_USER` | `apikey` (SendGrid) or your email |
| `MAIL_PASS` | your SendGrid API key or password |

The SMTP settings are already stored in the `options` DB table — consider reading from there rather than env vars if they are already configured in the admin panel.

---

### 🟡 Issue 4 — `php_value max_execution_time 600` in `.htaccess` (MEDIUM)

**The problem:**
Azure App Service may not honour `php_value` directives inside `.htaccess` at the default configuration level.

**The fix:**
Create a `.user.ini` file in the project root alongside `index.php`:
```ini
max_execution_time = 600
memory_limit = 256M
upload_max_filesize = 20M
post_max_size = 20M
```
Azure App Service reads `.user.ini` for PHP runtime settings. ✅

Remove the `php_value max_execution_time 600` line from `.htaccess`.

---

### 🟡 Issue 5 — Twilio Subdirectory Composer (MEDIUM)

**The problem:**
`application/controllers/Twillio/` has its **own `composer.json`** and `vendor/` directory separate from the root. Azure's deployment pipeline only runs `composer install` at the root level — the Twilio vendor directory needs to be committed or handled separately.

**The fix (two options):**
- **Option A:** Commit `Twillio/vendor/` to git (currently the git status shows it as tracked and modified — this appears to already be the case)
- **Option B:** Add a deployment script (`.deployment` / `deploy.sh`) that runs `composer install` inside `Twillio/` after the root install

Option A is already effectively in place since the Twillio vendor files appear in git.

---

### 🟡 Issue 6 — Sessions on Multiple Instances (MEDIUM)

**The problem:**
If Azure scales the app to **2+ instances** (auto-scale), PHP file-based sessions are stored on each instance's local filesystem. A user authenticated on instance 1 will be logged out if their next request hits instance 2.

**For now (single instance):** Not a problem. Basic/Standard B1 plans with a single instance are fine for HDBS traffic volumes.

**If you scale later:** Use Azure Cache for Redis as the session store:
```php
// in index.php, before session_start():
ini_set('session.save_handler', 'redis');
ini_set('session.save_path', getenv('REDIS_URL'));
```

---

### 🟢 Issue 7 — Windows Paths in `env.php` Fallback (LOW)

**The problem:**
`env.php` has `C:/xampp82/htdocs/...` as default `APP_PATH`. On Azure Linux this path doesn't exist.

**Not actually a problem** as long as `APP_PATH` is set in Azure App Settings (Issue 2 above). The `env.php` fallback is only used when `APP_PATH` env var is not set. On Azure, it will always be set.

---

## 4. Azure Database for MySQL — Connection Notes

Azure MySQL uses **SSL by default** and requires a specific connection string format:

```
Username:  hdbs_app@yourservername
Host:      yourservername.mysql.database.azure.com
Port:      3306
SSL:       Required
```

Your `mysqli` connection will need SSL enabled:
```php
$con = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$con->ssl_set(null, null, '/home/site/ssl/DigiCertGlobalRootCA.crt.pem', null, null);
```
Download the Azure SSL certificate and include it in your deployment. Alternatively, disable SSL enforcement on the Azure MySQL Flexible Server for dev/test (not recommended for production).

---

## 5. Deployment Checklist

### One-time Azure setup
- [ ] Create **App Service** (Linux, PHP 8.2, Basic B2 or Standard S1)
- [ ] Create **Azure Database for MySQL Flexible Server** (MySQL 8.0)
- [ ] Create **Azure Storage Account** + File Share for uploads (Option A above)
- [ ] Mount File Share to `/home/site/wwwroot/application/web/upload/` in App Service Path Mappings
- [ ] Create database and import schema from `application/config/update_db_*.sql` files
- [ ] Set all **App Settings** (env vars) listed in Issue 2 above

### Code changes before first deploy
- [ ] Update `db.php` to use `getenv()` first (Issue 2)
- [ ] Add `isSMTP()` + SMTP config to PHPMailer in `App.php` (Issue 3)
- [ ] Create `.user.ini` with PHP settings (Issue 4)
- [ ] Remove `php_value max_execution_time 600` from `.htaccess`
- [ ] Update `constants.php` `INSTALL_PATH`/`INSTALL_URL` to check `getenv()` first

### Deployment
- [ ] Push code to Azure via GitHub Actions, Azure DevOps, or `git push azure main`
- [ ] Azure runs `composer install` automatically (root vendor/)
- [ ] Verify Twilio vendor is present (Issue 5)
- [ ] Run database migrations if any pending

### Post-deploy verification
- [ ] App loads without errors
- [ ] Admin login works
- [ ] File upload works and persists after app restart
- [ ] Email sends (PHPMailer via SMTP)
- [ ] PDF generation (mPDF) works
- [ ] Stripe payment flow works

---

## 6. Compatibility Summary

| Item | Status | Action needed |
|---|---|---|
| PHP 8.2 runtime | ✅ Compatible | None |
| MySQL / mysqli | ✅ Compatible | Configure Azure MySQL endpoint |
| Composer libs (PHPMailer, mPDF, Twilio) | ✅ Compatible | None |
| `.htaccess` / mod_rewrite | ✅ Compatible | Move `php_value` to `.user.ini` |
| Stripe payments | ✅ Compatible | None |
| All security fixes (CSRF, XSS, SQL) | ✅ Compatible | None |
| DB credentials from env vars | ✅ Mostly done | Update `db.php` to check `getenv()` first |
| File uploads (persistence) | ⚠️ Needs fix | Mount Azure Files to upload directory |
| Email sending | ⚠️ Needs fix | Configure SMTP relay (SendGrid) |
| Sessions (single instance) | ✅ Fine | No action unless you scale |
| Sessions (multi-instance) | ⚠️ Future | Add Redis session store when scaling |
| Windows paths | ✅ Fine | Set `APP_PATH` in App Settings |

---

## 7. Cost Estimate (Approximate USD/month)

| Service | Tier | ~Cost/month |
|---|---|---|
| App Service (Linux) | Basic B2 (2 core, 3.5 GB) | ~$75 |
| Azure Database for MySQL | Flexible Server, Burstable B1ms | ~$15 |
| Azure Storage (file uploads) | LRS, ~20 GB | ~$1 |
| **Total** | | **~$91/month** |

Standard S1 ($70) gives auto-scale and custom deployment slots if needed.

---

_End of document._
