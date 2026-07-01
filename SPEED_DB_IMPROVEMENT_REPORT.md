# HDBS Puja Payments - Speed and Database Connection Improvement Report

Date: July 1, 2026

## Purpose

The application was running much slower when connected to Azure MySQL compared with the local database. The main reason was not PHP 8.4 itself, but repeated database connections and repeated database queries during a single page request.

Azure DB is remote, so every extra connection or query adds network latency. A dummy test page using only one query loaded quickly, which confirmed that the database can respond fast when query count is low.

## Improvements Completed

### 1. Reused Model Database Connections

File changed:

`core/framework/Model.class.php`

Before:

Each model object could create its own PDO database connection.

After:

A static PDO pool was added so models reuse the same database connection during one request.

Benefit:

This reduces repeated Azure DB connection handshakes and improves page load speed.

### 2. Reused Direct PDO Connections

File changed:

`application/config/functions.inc.php`

Before:

Every call to `gz_pdo_connect()` created a new PDO connection.

After:

`gz_pdo_connect()` now keeps a static connection cache and reuses the same connection for matching credentials during the request.

Benefit:

AJAX pages and controller methods that directly call `gz_pdo_connect()` no longer create unnecessary repeated connections.

### 3. Reduced Repeated SQL Mode Setup

Files changed:

`core/framework/Model.class.php`

`application/config/functions.inc.php`

Before:

The app could run this repeatedly:

```sql
SET SESSION sql_mode = REPLACE(@@SESSION.sql_mode, 'ONLY_FULL_GROUP_BY', '')
```

After:

This now runs only once when a new connection is created.

Benefit:

Reduces unnecessary SQL statements during page load.

### 4. Reduced Repeated Rate Limit Table Check

File changed:

`application/config/functions.inc.php`

Before:

`CREATE TABLE IF NOT EXISTS login_attempts` could run multiple times in one request.

After:

A static `$ensured` flag was added so the table check runs only once per request.

Benefit:

Reduces repeated metadata/table-check queries.

### 5. Improved Puja Registration Schema Check

File changed:

`application/models/pujaregistration.model.php`

Before:

The app checked columns one by one using multiple `SHOW COLUMNS ... LIKE ...` queries.

After:

The app now fetches all columns once using `SHOW COLUMNS`, then checks the result in PHP.

Benefit:

Fewer metadata queries against Azure DB.

Note:

This is an improvement, but schema checks should eventually be moved fully out of normal page load and into migration scripts only.

### 6. Added OptionModel Per-Request Cache

File changed:

`application/models/Option.model.php`

Before:

Many controllers called both:

```php
getAllPairValues()
getAllPairs()
```

Both methods were reading the same options table again and again.

After:

`OptionModel` now caches option rows during the same request.

Benefit:

Repeated option reads are served from memory instead of querying Azure DB again.

Observed Result:

Application speed improved after this change, confirming repeated database reads were a major cause of slowness.

## Current Database Connection Structure

The application currently has two main runtime database connection paths.

### Main MVC Application

File:

`core/framework/Model.class.php`

Used by normal models and controllers.

Connection type:

PDO

### Direct Helper / AJAX Connection

File:

`application/config/functions.inc.php`

Function:

`gz_pdo_connect()`

Used by direct AJAX/controller methods such as:

`ajax-db-search.php`

`application/controllers/GzFront.php`

`application/controllers/PujaSankalpa.php`

`application/controllers/PujaDonations.php`

### Separate Standalone Connection

File:

`config.php`

Used by standalone scripts such as:

`send-otp.php`

`verify-otp.php`

Connection type:

mysqli

## Why Dummy Login Test Page Was Fast

The dummy page connected to Azure DB and fetched only 50 rows from `confirm_code`.

It performed:

1. One database connection
2. One simple query
3. Limited result set

The full application performs many more model calls, option reads, language reads, schema checks, and page-specific queries. On Azure, every extra query adds network latency.

## Remaining Recommended Optimizations

### 1. Add Query Timing Profiler

Add logging for:

`URL`

`total page time`

`DB connect time`

`query count`

`slowest queries`

This will identify exactly which pages and queries are slow.

### 2. Remove Runtime Schema Changes From Page Load

Avoid running these during normal user page requests:

```sql
SHOW COLUMNS
ALTER TABLE
CREATE TABLE IF NOT EXISTS
```

These should run only in migration/admin scripts.

### 3. Cache Static Configuration Data

OptionModel caching helped. Similar caching can be applied to language/local settings and other static configuration tables.

### 4. Reduce Queries Inside Loops

Any query running inside a loop should be reviewed and converted to joins or bulk queries where possible.

### 5. Improve Browser Asset Caching

Many files use:

```php
?v=' . time()
```

This prevents browser caching because the version changes on every request. Replace this with a fixed application version or file modification time.

## Summary

The speed improvement came mainly from reducing repeated database connections and repeated database reads during a single request. The most visible improvement was the `OptionModel` cache, because many controllers repeatedly loaded the same options data.

The next best step is to add query timing logs and optimize the highest-cost pages based on real measurements.
