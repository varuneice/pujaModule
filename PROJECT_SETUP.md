# HDBS Puja Payments Setup

Use this checklist when setting up the project on a new system.

## Composer Dependencies

Run Composer in the project root:

```bash
composer install --no-dev
```

This installs the root dependencies used by the app, including PHPMailer and mPDF.

Then install Twilio dependencies from the nested Twilio folder:

```bash
cd application/controllers/Twillio
composer install --no-dev
```

This installs `twilio/sdk` and creates `application/controllers/Twillio/vendor/`.

## Local Config

Create or copy the local config file on the target system:

```text
application/config/env.php
```

This file is intentionally not committed to Git because it contains local secrets such as Twilio credentials.

## Stripe Keys

Stripe keys are read from the database table:

```text
pujapaymetstripeoptions
```

Make sure this table has the correct `stripe_api_key` and `stripe_publish_key` values for the target environment.

## Git-Ignored Files

These folders/files are expected to be missing after cloning and are recreated locally:

```text
vendor/
application/controllers/Twillio/vendor/
application/config/env.php
application/config/env_*.php
logs and error files
```

## Quick Verification

After setup, check PHP syntax for key files:

```bash
php -l index.php
php -l application/config/constants.php
php -l application/controllers/Foodcoupon.php
```
