# Puja Admin Changes Reminder

## What was created

Created an admin page for managing Puja registration values:

- YTD Sponsorship Levels
- Registration Settings

Admin page route:

```text
PujaYtdTiers/index
```

Admin menu location:

```text
Admin -> Puja Registration -> YTD Sponsorship Levels
```

## New database tables

These tables are created automatically when the admin page is opened:

```text
puja_ytd_tiers
puja_registration_settings
```

The Azure database user must have table-create permission. If not, the tables need to be created manually.

## Seeded YTD levels

The YTD table seeds these default ranges:

```text
Base 1:   0-150
Base 2:   150-350
Silver:   750-999
Gold:     1000-1499
Platinum: 1500-2199
Emerald:  2200-4999
Diamond:  5000 and above
```

## Registration setting

The registration settings table seeds:

```text
child_yob_cutoff = 2004
```

This is for replacing the hardcoded public registration value later:

```javascript
var compareyear = '2002';
```

Current hardcoded locations checked:

```text
application/views/PujaOnlinePayments/PujaOnlinePayments.php
```

Known lines from local check:

```text
YOB 2002 or later
var compareyear = '2002';
```

## Files to upload on Azure

Upload these files:

```text
application/models/pujaytdtier.model.php
application/models/pujaregistrationsetting.model.php
application/controllers/PujaYtdTiers.php
application/views/PujaYtdTiers/index.php
application/views/Layouts/admin/menu/sidebar.php
```

## Important note

The admin UI is created, but the public Puja registration page is not yet reading these new database values.

Next step later:

```text
Use puja_ytd_tiers and puja_registration_settings inside PujaOnlinePayments.php
instead of hardcoded YTD ranges and compareyear.
```
