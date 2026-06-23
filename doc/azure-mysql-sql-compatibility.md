# HDBS Puja Module — SQL Compatibility: XAMPP MySQL vs Azure MySQL 8.0
_Created: 2026-03-19_

---

## Summary

Most SQL in the codebase will work on Azure MySQL 8.0 **without any changes**.
There are **2 breaking issues** and **1 minor schema issue** that must be fixed before migrating.

| # | Issue | Severity | Files affected |
|---|---|---|---|
| 1 | `0000-00-00` zero dates — rejected by Azure MySQL strict mode | 🔴 Breaking | `ConfirmCode.model.php`, `BadgeReport.php`, `Foodcoupon` views, existing DB data |
| 2 | `ONLY_FULL_GROUP_BY` — non-aggregated column in SELECT with GROUP BY | 🔴 Breaking | `Donationnewview.model.php` |
| 3 | `DEFAULT CHARSET=utf8` in schema — should be `utf8mb4` | 🟡 Minor | `database.sql` (14 tables) |
| 4 | All other SQL (DATE_FORMAT, CURDATE, YEAR, INTERVAL, etc.) | ✅ Compatible | — |

---

## Why Azure MySQL Behaves Differently

Your local XAMPP MySQL likely runs with a **relaxed SQL mode**. Azure Database for MySQL 8.0 enforces a **strict SQL mode by default**:

```
STRICT_TRANS_TABLES, NO_ZERO_IN_DATE, NO_ZERO_DATE,
ERROR_FOR_DIVISION_BY_ZERO, ONLY_FULL_GROUP_BY,
NO_ENGINE_SUBSTITUTION
```

These are also the MySQL 8.0 defaults — so this is not Azure-specific, it is MySQL 8.0 behaviour.
If your local XAMPP is running MySQL 5.7 with relaxed mode, these issues are currently silent.

---

## Issue 1 — `0000-00-00` Zero Dates 🔴 Breaking

### What the problem is

`NO_ZERO_DATE` and `NO_ZERO_IN_DATE` modes make MySQL **reject** storing `0000-00-00` as a date value. Queries that filter on `= "0000-00-00"` will still work syntactically but any attempt to INSERT or UPDATE a row with a zero date will fail with an error.

More importantly: if your **existing database already has rows with `0000-00-00` dates**, the dump and restore to Azure MySQL 8.0 will **fail on import** unless you handle this.

### Where it appears in the code

**`application/models/ConfirmCode.model.php` — lines 25, 58, 73** (active queries):
```php
// Line 25 — filters on zero date
$sql = '... WHERE UpdatedOn="0000-00-00" AND paymentfrom ="pujaregistration" ...';

// Line 58, 73 — same pattern
AND UpdatedOn="0000-00-00"
```

**`application/controllers/BadgeReport.php` — line 66** (reads zero date from DB):
```php
if ($arr[0]['Date'] === '0000-00-00') {
```

**`application/views/Foodcoupon/component/foodcoupontab_table.php` — line 95:**
```php
if ($tpl['foodarr'][$i]['Date'] == null || $tpl['foodarr'][$i]['Date'] == "0000-00-00")
```

### The fix — 3 steps

**Step 1 — Fix the code to use NULL instead of `0000-00-00`:**

In `ConfirmCode.model.php`, change:
```php
// BEFORE
WHERE UpdatedOn="0000-00-00"

// AFTER
WHERE UpdatedOn IS NULL
```

In `BadgeReport.php`:
```php
// BEFORE
if ($arr[0]['Date'] === '0000-00-00')

// AFTER
if (empty($arr[0]['Date']) || $arr[0]['Date'] === '0000-00-00')
```

The view checks for `null || "0000-00-00"` already handle both — these are fine.

**Step 2 — Alter the DB columns to allow NULL:**

Run on Azure MySQL after import:
```sql
-- Find all columns that store zero dates and allow NULL on them
-- (run SHOW COLUMNS FROM tablename to find DATE/DATETIME columns first)
ALTER TABLE confirm_code MODIFY UpdatedOn DATE NULL DEFAULT NULL;
-- repeat for any other zero-date columns
```

**Step 3 — Fix the database dump before importing to Azure:**

When exporting from XAMPP for import to Azure:
```bash
# Export with zero-date rows converted to NULL
mysqldump --databases durgab5_HDBS_Payment_Prod \
  --compatible=ansi \
  --hex-blob \
  | sed "s/0000-00-00 00:00:00/NULL/g" \
  | sed "s/'0000-00-00'/NULL/g" \
  > hdbs_puja_export.sql
```
Or open the dump file and do a find-replace of `'0000-00-00'` → `NULL` before importing.

---

## Issue 2 — `ONLY_FULL_GROUP_BY` Violation 🔴 Breaking

### What the problem is

MySQL 8.0 enforces `ONLY_FULL_GROUP_BY` — every column in a SELECT must either:
- Be in the GROUP BY clause, OR
- Be wrapped in an aggregate function (`SUM`, `COUNT`, `MIN`, `MAX`, `ANY_VALUE`)

### Where it appears

**`application/models/Donationnewview.model.php` — line 105:**
```php
$sql = 'SELECT donationnewview.id as ID,          ← not aggregated, not in GROUP BY ❌
               donationnewview.pay_for AS MemberType,
               sum(donationnewview.Amount) AS Revenue
        FROM ' . $this->getTable() . '
        WHERE (...)
        GROUP BY MemberType';                       ← only MemberType, id is missing
```

This query will throw:
```
ERROR 1055: Expression #1 of SELECT list is not in GROUP BY clause and contains
nonaggregated column 'donationnewview.id' which is not functionally dependent
on columns in GROUP BY clause
```

### The fix

Option A — Add `ANY_VALUE()` around `id` (best — keeps the query intent):
```php
$sql = 'SELECT ANY_VALUE(donationnewview.id) as ID,
               donationnewview.pay_for AS MemberType,
               sum(donationnewview.Amount) AS Revenue
        FROM ' . $this->getTable() . '
        WHERE (...)
        GROUP BY MemberType';
```

Option B — Add `id` to the GROUP BY (changes result semantics — one row per id+MemberType):
```php
GROUP BY donationnewview.id, MemberType
```

**Also verify:** The `Admin.php` GROUP BY query (line 379) groups by `year(finalDate), month(finalDate)` and selects only those plus `SUM(total)` — this is correct and will work fine. ✅

---

## Issue 3 — `DEFAULT CHARSET=utf8` in Schema 🟡 Minor

### What it is

`application/config/database.sql` defines 14 tables with:
```sql
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

### Why it is not breaking

In MySQL 8.0, `utf8` is an **alias for `utf8mb4`** (they changed this in MySQL 8.0.28+). So the tables will actually be created as `utf8mb4` on Azure. This is a good thing — `utf8mb4` supports full Unicode including emoji.

### What to do

When preparing the schema for Azure, change all `CHARSET=utf8` to `CHARSET=utf8mb4` for clarity and future-proofing:

```bash
# In database.sql:
sed -i 's/DEFAULT CHARSET=utf8;/DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;/g' database.sql
```

The PHP connections already use `utf8mb4`:
```php
$con->set_charset('utf8mb4');  // ✅ already correct in config.php, GzFront.php, PujaDonations.php
```

---

## What Is Fully Compatible ✅

| SQL Feature | Used in code | Azure MySQL 8.0 |
|---|---|---|
| `DATE_FORMAT()` | Yes — many models | ✅ Works |
| `CURDATE()` / `NOW()` | Yes | ✅ Works |
| `YEAR()` / `MONTH()` | Yes | ✅ Works |
| `INTERVAL` date arithmetic | Yes | ✅ Works |
| `LIKE ?` prepared statements | Yes | ✅ Works |
| `SUM()` / `COUNT()` aggregates | Yes | ✅ Works |
| `ORDER BY` | Yes | ✅ Works |
| `LIMIT` | Yes | ✅ Works |
| `InnoDB` engine | Yes — all tables | ✅ Default on Azure |
| `utf8mb4` connection charset | Yes | ✅ Works |
| `AUTO_INCREMENT` | Yes | ✅ Works |
| `INSERT INTO ... VALUES` | Yes | ✅ Works |
| `UPDATE ... WHERE` | Yes | ✅ Works |
| `DELETE FROM ... WHERE` | Yes | ✅ Works |
| Subqueries | Yes | ✅ Works |
| `CONCAT()` | Yes | ✅ Works |

---

## Migration Checklist — Database

### Before exporting from XAMPP
- [ ] Run `SHOW VARIABLES LIKE 'sql_mode'` on XAMPP MySQL — note the current mode
- [ ] Find all DATE/DATETIME columns across all tables — identify which ones store `0000-00-00`
- [ ] Run UPDATE to convert zero dates to NULL:
  ```sql
  UPDATE confirm_code SET UpdatedOn = NULL WHERE UpdatedOn = '0000-00-00';
  -- repeat for each table/column that has zero dates
  ```
- [ ] Export using `mysqldump` with `--hex-blob --single-transaction`

### On Azure MySQL after import
- [ ] Set sql_mode if needed (or adjust to match your requirements):
  ```sql
  -- To check current mode:
  SELECT @@sql_mode;
  -- To relax ONLY_FULL_GROUP_BY temporarily while fixing queries (not recommended for prod):
  SET GLOBAL sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_DATE,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
  ```
- [ ] Fix `Donationnewview.model.php` GROUP BY query (Issue 2)
- [ ] Fix `ConfirmCode.model.php` zero-date WHERE clauses (Issue 1)
- [ ] Verify `BadgeReport.php` handles NULL dates correctly
- [ ] Test the admin statistics page (uses GROUP BY on dates)

---

## Quick Fix Summary — Code Changes Required

| File | Line | Change |
|---|---|---|
| `application/models/Donationnewview.model.php` | 105 | Wrap `id` in `ANY_VALUE()` |
| `application/models/ConfirmCode.model.php` | 25, 58, 73 | `UpdatedOn="0000-00-00"` → `UpdatedOn IS NULL` |
| `application/controllers/BadgeReport.php` | 66 | Add `empty()` check alongside `=== '0000-00-00'` |
| `application/config/database.sql` | all tables | `CHARSET=utf8` → `CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci` |

---

_End of document._
