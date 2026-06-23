# Security Test Results — RED Phase (Pre-Fix Baseline)
_Date: 2026-03-12_
_PHPUnit: not yet configured | PHP: 7.4.30_

---

## Summary

This document records the anticipated RED phase — the pre-fix baseline for the pujaModule security test suite. **No test suite has been written yet.** This document defines the test structure to be implemented and documents the expected failure state based on the codebase audit in [`codebase-observations.md`](./codebase-observations.md).

Once tests are written and executed, the actual run results (pass/fail counts, specific error messages) will replace the anticipated findings below. As fixes are applied, results will be updated in place — or a separate GREEN phase document will be created.

| Metric | Count |
|---|---|
| Total tests run | — (not yet run) |
| Passed | — |
| Failed | — (all expected to fail) |
| Skipped | — |
| Errors | — |

---

## Anticipated Test Categories

### CSRF — Expected: 4 failures

#### 1. `CsrfTest::testBaseControllerValidatesCsrfToken` — Expected FAIL
- **File:** `core/framework/Controller.class.php`
- **Finding:** No `csrf_token` validation exists anywhere in the base controller.
  All POST requests across all 53+ controllers are accepted without any token check.
- **Fix required:** Add `$_SESSION['csrf_token']` validation in `beforeFilter()` or equivalent.

#### 2. `CsrfTest::testBaseControllerGeneratesCsrfToken` — Expected FAIL
- **File:** `core/framework/Controller.class.php`
- **Finding:** No CSRF token is generated for views. `random_bytes()` is not used anywhere in the controller.
- **Fix required:** Add `$_SESSION['csrf_token'] = bin2hex(random_bytes(32));` in controller initialisation.

#### 3. `CsrfTest::testViewFormsContainCsrfToken` — Expected FAIL
- **Finding:** View files across 35+ directories contain POST forms with no CSRF hidden input field.
- **Representative files affected:**
  - `application/views/Admin/login.php`
  - `application/views/Admin/forgot.php`
  - `application/views/Pujaregistration/` (all form views)
  - `application/views/PujaOnlinePayments/` (all payment form views)
  - `application/views/Member/checkout.php`
  - `application/views/PujaDonations/` (donation form views)
  - `application/views/Badges/index.php`
  - `application/views/Foodcoupon/index.php`
  - `application/views/GzFront/component/booking_form.php`
  - _(+ many additional view files across all 35+ controller directories)_
- **Fix required:** Add `<input type="hidden" name="csrf_token" value="...">` to every POST form.

#### 4. `CsrfTest::testBaseControllerUsesTimingSafeComparison` — Expected FAIL
- **File:** `core/framework/Controller.class.php`
- **Finding:** `hash_equals()` is not used anywhere in the controller. No timing-safe comparison exists.
- **Fix required:** Use `hash_equals($_SESSION['csrf_token'], $submitted_token)` — not `===`.

---

### SQL Injection — Expected: 1+ failures

#### 5. `SqlInjectionTest::testAjaxDbSearchHasNoRawSqlInterpolation` — Expected FAIL
- **File:** `ajax-db-search.php`
- **Finding (line ~14):**
  ```
  WHERE ( F_name LIKE '{$_GET['term']}%' OR L_Name LIKE '{$_GET['term']}%'
  OR Zip LIKE '{$_GET['term']}%' OR Sp_FName LIKE '{$_GET['term']}%'
  OR Sp_LName LIKE '{$_GET['term']}%' OR Member_id LIKE '{$_GET['term']}%' )
  AND (FirstSal != 'Late' OR SpouseSal != 'Late')
  AND (Active IS NULL OR Active='') LIMIT 20
  ```
- **Severity:** CRITICAL — this endpoint requires no authentication.
- **Fix required:** Parameterized prepared statement with `bind_param('ssssss', ...)` across 6 LIKE clauses.

---

### XSS — Expected: 3+ failures

#### 6. `XssTest::testAdminControllerHasNoUnescapedOutput` — Expected FAIL
- **File:** `application/controllers/Admin.php`
- **Finding:** Echo statements without `htmlspecialchars()` wrapping in HTML response contexts.
- **Fix required:** Wrap HTML-context output in `htmlspecialchars($value, ENT_QUOTES, 'UTF-8')`.

#### 7. `XssTest::testMemberControllerHasNoUnescapedOutput` — Expected FAIL
- **File:** `application/controllers/Member.php`
- **Finding:** Echo statements in HTML response contexts without escaping.
- **Fix required:** Wrap HTML-context output in `htmlspecialchars()`; use `print` for JSON/CSV output contexts where escaping would corrupt the format.

#### 8. `XssTest::testGzFrontControllerHasNoUnescapedOutput` — Expected FAIL
- **File:** `application/controllers/GzFront.php`
- **Finding:** Values sourced from `$_POST` (payment callback fields) echoed without escaping.
- **Fix required:** Wrap `$_POST`-sourced values echoed in HTML with `htmlspecialchars($value, ENT_QUOTES, 'UTF-8')`.

---

### File Upload — Expected: 1–2 failures

#### 9. `FileUploadTest::testBadgesControllerValidatesMimeType` — Expected FAIL
- **File:** `application/controllers/Badges.php`
- **Finding:** No `mime_content_type()`, `finfo_file()`, or `FILEINFO_MIME_TYPE` call exists in the import/upload code path. Files are accepted and processed without any MIME type check.
- **Fix required:** Add MIME type validation using `finfo_open(FILEINFO_MIME_TYPE)` + `finfo_file()` before processing any uploaded file.

#### 10. `FileUploadTest::testBadgesControllerValidatesCsvHeaders` — PASS/FAIL (to be verified)
- **File:** `application/controllers/Badges.php`
- **Note:** In the priestModule equivalent, this was found to already PASS due to `header()` PHP function calls satisfying the scanner's `strpos` check. The same may apply here — verify during implementation.

---

## Positive Control Tests — Expected: PASS

These tests confirm the test harness itself is working and should always pass:

| Test | Notes |
|---|---|
| `FileUploadTest::testUploadHandlerEnforcesFileSizeLimit` | `class.upload.php` already has size handling |
| `FileUploadTest::testUploadHandlerSanitisesFilename` | `class.upload.php` contains `preg_replace`/`basename` |
| `FileUploadTest::testValidCsvPassesMimeAllowList` | Positive control |
| `FileUploadTest::testBinaryFileFailsMimeAllowList` | Positive control |
| `FileUploadTest::testContentScanDetectsPhpTags` | Positive control |
| `FileUploadTest::testPathTraversalIsRemovedByBasename` | Positive control |
| `SqlInjectionTest::testPreparedStatementPatternIsNotFlaggedAsDangerous` | Positive control |
| `XssTest::testProperlyEscapedOutputIsNotFlagged` | Positive control |

---

## Tests Requiring MySQL

These tests require the `hdbs_test` database. Run setup after starting MySQL.

| Test | Reason |
|---|---|
| `SqlInjectionTest::testRawQueryWithInjectionPayloadIsVulnerable` | MySQL required |
| `SqlInjectionTest::testPreparedStatementNeutralisesInjectionPayload` | MySQL required |
| `SqlInjectionTest::testMemberIdSearchIsSafe` | MySQL required |
| `SqlInjectionTest::testNumericIdIsCastToInteger` | MySQL required |

---

## Fix Tracking

| # | Vulnerability | Test(s) | Status | Date |
|---|---|---|---|---|
| 1 | SQL injection — `ajax-db-search.php` | `testAjaxDbSearchHasNoRawSqlInterpolation` | Pending | — |
| 2 | XSS — `GzFront.php` | `testGzFrontControllerHasNoUnescapedOutput` | Pending | — |
| 3 | XSS — `Admin.php` | `testAdminControllerHasNoUnescapedOutput` | Pending | — |
| 4 | XSS — `Member.php` | `testMemberControllerHasNoUnescapedOutput` | Pending | — |
| 5 | CSRF — base Controller + all forms | `testBaseControllerValidatesCsrfToken`, `testBaseControllerGeneratesCsrfToken`, `testViewFormsContainCsrfToken`, `testBaseControllerUsesTimingSafeComparison` | Pending | — |
| 6 | File upload — MIME validation | `testBadgesControllerValidatesMimeType` | Pending | — |

**Phase 1 items (no automated tests — manual verification):**

| # | Item | Status | Date |
|---|---|---|---|
| P1-1 | Remove/protect backup files | Pending | — |
| P1-2 | Secure or remove any exposed data dumps | Pending | — |
| P1-3 | Block direct browser access to `.sql`, `.bak` files | Pending | — |

_Status values: Pending → In Progress → Fixed (date)_

---

## Related Documents

- [`codebase-observations.md`](./codebase-observations.md) — Full audit
- [`security-remediation-plan.md`](./security-remediation-plan.md) — Fix steps by priority
- [`php8-migration-plan.md`](./php8-migration-plan.md) — PHP upgrade plan

---

_End of document._
