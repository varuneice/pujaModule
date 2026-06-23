# HDBS Payment – Puja Module: Codebase Observations
_Generated: 2026-03-12_

---

## 1. Project Overview

**HDBS Payment (Puja Module)** is a PHP-based Puja Registration and Payment System for a Hindu/Durgabari/Brahmin Society. It handles the full lifecycle of puja event management, member participation, and financial transactions for the annual Puja festival.

### Core Functions
- Puja registration (early, regular, and family registration workflows)
- Online puja payments and sponsorships
- Food coupon management and redemption
- Paid parking and passes management
- Badge creation and badge report generation
- Ticket management (puja tickets, admin ticketing)
- Magazine subscriptions (PujaMagazine)
- Sankalpa (puja dedication) registration
- Member lookup and donation tracking
- Mail-in option management
- Discount and custom pricing management
- Calendar and time-slot based priest booking (GzFront)
- Statistics and reporting

---

## 2. Current Technical Stack

### Backend
| Component | Details |
|---|---|
| Language | PHP 7.4.30 (procedural & OOP) — **EOL since Nov 2022** |
| Framework | Custom lightweight MVC (not Laravel/Symfony) |
| Database | MySQL via MySQLi + custom Fluent query builder |
| ORM | Custom chainable query builder (SelectQuery, InsertQuery, UpdateQuery, DeleteQuery) |
| Authentication | Session-based (`$_SESSION['admin_user']`, `$_SESSION['front_user']`) |
| Authorization | Role-Based Access Control (RBAC) — 14+ user types |

### Frontend
| Component | Version | Status |
|---|---|---|
| jQuery | 1.9.1 | Outdated |
| Bootstrap | 3 | Outdated |
| TinyMCE | Legacy | Outdated |
| KCFinder | Legacy | File browser |
| jQuery UI | Legacy | — |
| jQuery Validation | Legacy | Form validation |
| Date Range Picker | Legacy | — |

### Third-party Integrations
| Integration | Purpose | Status |
|---|---|---|
| Stripe | Primary payment gateway | Legacy v2/v3 API |
| Authorize.Net | Secondary payment gateway | Present (`sdk-php-master/`) |
| Twilio SDK | SMS/communications | Active (`controllers/Twillio/`) |
| PHPMailer | Email sending | v5.2.4 (outdated) |
| mPDF | PDF generation | v5.7 (outdated) |
| ABCalendar | Calendar UI component | Present |

### Infrastructure
- **Web Server:** Apache (XAMPP)
- **URL Routing:** `.htaccess` rewrite rules → `index.php`
- **Session Name:** `TimeSlotBookingCalendarPHP`
- **Config:** PHP flat files (`config.php`, `constants.php`)
- **Dependency Management:** Composer (Twilio SDK only; PHPMailer and mPDF bundled manually)

### Project Scale
- **Total PHP files:** ~3,000+
- **Controllers:** 53+ active
- **Models:** 64 classes
- **Views:** 358 templates
- **User Roles:** 14+ (Admin, Editor, Volunteer, Events, Parking Admin, Badges Admin, Food Coupon Admin, Education, Registration, Vendor, etc.)

---

## 3. Architecture

### Directory Structure
```
pujaModule/
├── index.php                    # Main entry point / router
├── config.php                   # Database credentials
├── ajax-db-search.php           # Public AJAX member search endpoint
├── application/
│   ├── config/                  # Constants, app configuration, SQL migrations
│   ├── controllers/             # 53+ PHP controllers
│   ├── models/                  # 64 model classes
│   ├── views/                   # 358 view templates
│   ├── helpers/                 # Payment integrations, utilities
│   │   ├── PHPMailer_5.2.4/
│   │   ├── MPDF57/
│   │   ├── stripe/
│   │   ├── sdk-php-master/      # Authorize.Net SDK
│   │   ├── uploader/
│   │   └── ABCalendar/
│   ├── locale/
│   ├── templates/
│   └── web/                     # CSS, JS, uploads
├── core/
│   ├── bootstrap.php            # MVC routing engine
│   └── framework/               # Base Controller, Model, query builder
└── doc/                         # Documentation (this directory)
```

### MVC Pattern
- Controllers dispatch via URL routing
- Views loaded dynamically based on action names
- Template variables passed via `$this->tpl[]`
- Layouts: `admin`, `login`, `default`, `empty`

---

## 4. Security Issues

### Critical
| Issue | Location | Details |
|---|---|---|
| **SQL Injection** | `ajax-db-search.php` | Direct interpolation of `$_GET['term']` into raw SQL string — no authentication required to reach this endpoint |
| **Disabled XSS Protection** | `index.php` lines 1–7 | A "SITELOCK XSS VULNERABILITY FIX" block that applied `htmlentities()` to common `$_REQUEST` fields is entirely commented out |

### High
| Issue | Details |
|---|---|
| **No CSRF Protection** | POST requests across all forms lack anti-CSRF tokens |
| **XSS (Cross-Site Scripting)** | Unsanitized user data echoed directly into HTML — common pattern across controllers and views |
| **CORS Wildcard Header** | `.htaccess` sets `Access-Control-Allow-Origin: *` — allows any origin to make cross-origin requests including reading responses |
| **Legacy Stripe Integration** | Stripe integration present; version and API compatibility should be verified against current Stripe requirements |
| **No File Upload Validation** | CSV imports and file uploads lack server-side content-type or MIME validation |
| **`display_errors` Enabled** | `index.php` sets `ini_set("display_errors", "On")` — PHP error details exposed to end users |

### Medium
| Issue | Details |
|---|---|
| **Hardcoded DB Credentials** | `config.php` and `constants.php` store credentials in plaintext; uses `root` with empty password; a commented-out production password (`GhKiBW1zVyCL`) is visible in `constants.php` source |
| **Error Reporting Suppressed** | `error_reporting(0)` in `application/config/config.php` hides all errors (while `index.php` simultaneously enables display of errors — a contradictory configuration) |
| **Backup Files in Production** | Multiple `*backup.php`, `*_bkp.php`, `*_HIST_*.php`, and `*_July.php` style files committed to the active codebase |
| **Hardcoded localhost URLs** | `constants.php` and email templates reference `http://localhost:8082/HDBS_Payment/pujaModule/...` |
| **Weak Password Generation** | `Util::random_password()` and `Util::incrementalHash()` use `rand()` (non-cryptographic) for passwords and invoice numbers |
| **No Rate Limiting** | No rate limiting on login or payment endpoints |
| **Overly Permissive Upload Permissions** | `application/helpers/uploader/class.upload.php` calls `chmod(0777)` on uploaded files |
| **Max Execution Time 600s** | `.htaccess` sets `php_value max_execution_time 600` — long-running requests can be used as a denial-of-service vector |

### Security Posture Summary
| Aspect | Status |
|---|---|
| SQL Injection Prevention | FAIL |
| XSS Protection | FAIL |
| CSRF Protection | FAIL |
| Authentication | PASS (session-based, role checks present) |
| Data Exposure | FAIL (CORS wildcard, display_errors on) |
| API Security | FAIL (no rate limiting) |
| File Upload Validation | FAIL |
| Error Handling | FAIL (suppressed + displayed — contradictory) |
| Credentials | FAIL (plaintext, committed historical password visible) |

---

## 5. Code Quality & Technical Debt

### Code Smells
- **God Controllers:** `Admin.php` and `Member.php` contain 100+ methods each
- **Inconsistent ORM Usage:** Mix of custom query builder (good) and raw `mysqli_query()` (bad) throughout codebase
- **Backup Files in Production:** Multiple files with `backup`, `_bkp`, `_HIST_`, and date-stamped variants committed to the active codebase across controllers, models, and views
- **Commented-out Code:** Including an entire disabled security fix block in `index.php`
- **No Environment Separation:** No dev/staging/prod config distinction; all environments use the same config file with multiple commented-out credential sets visible in source
- **End-of-Life PHP Version:** Running PHP 7.4.30, which reached end-of-life on November 28, 2022 and no longer receives security patches. Current stable is PHP 8.3/8.4
- **Outdated Dependencies:** jQuery 1.9.1, Bootstrap 3, PHPMailer 5.2.4, mPDF 5.7 — all well behind current versions
- **No Cache Busting:** CSS/JS assets loaded without versioning
- **Silent Failures:** `@` error suppression operator used in `index.php` session calls
- **No Automated Tests:** No unit or integration test suite observed

### What Works Well
- Role-based access control is consistently applied across routes
- Custom query builder uses PDO prepared statements in newer code
- MVC structure is logical and consistently followed
- Twilio and Stripe integrations are present and functional
- The Installer controller and `constants.original.php` template show awareness of deployment portability

---

## 6. Recommended Actions

### Immediate (Before Live Payment Processing)
1. Remove or restrict all backup files from public paths
2. Move `config.php` outside the web root or use environment variables
3. Replace all raw SQL string interpolation with parameterized/prepared statements
4. Add CSRF token validation to all forms
5. Escape all output using `htmlspecialchars()` or equivalent
6. Remove the `Access-Control-Allow-Origin: *` CORS header or scope it to trusted origins
7. Restore or re-implement the commented-out XSS input filtering in `index.php` (properly — at the point of output, not input)

### Short-term
1. **Upgrade PHP from 7.4 to 8.2+ (LTS)** — requires compatibility audit for deprecated functions between 7.4 → 8.x
2. Upgrade jQuery and Bootstrap to current stable versions
3. Upgrade PHPMailer to v6+ and mPDF to v8+
4. Add input validation and sanitization layer
5. Replace `error_reporting(0)` with proper environment-aware error logging; remove `display_errors On` from `index.php`
6. Add rate limiting to login and payment endpoints
7. Remove all `*backup*`, `*_bkp*`, `*_HIST_*`, and date-stamped PHP files; use Git for version history
8. Replace hardcoded localhost URLs with config-driven base URLs
9. Remove commented-out production credentials from `constants.php`

### Long-term
1. Consider migration to a maintained framework (Laravel, Symfony)
2. Introduce automated testing (PHPUnit)
3. Implement proper CI/CD and environment-based configuration
4. Database field encryption for sensitive personal and payment data
5. API authentication for any exposed endpoints (JWT or OAuth)
6. Upgrade all outdated frontend and backend dependencies
7. Restrict file upload destinations to outside the web root; serve uploads via controller

---

_End of document._
