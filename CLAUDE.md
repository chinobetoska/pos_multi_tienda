# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

CodeIgniter 3 POS (Point of Sale) system for multiple stores/outlets. PHP backend with MySQL, Bootstrap 3 frontend. Deployed on Hostinger (PHP 8.2-8.5).

## Development Commands

No build system. This is a traditional LAMP stack app — serve with Apache + PHP.

```bash
# Local development (XAMPP/WAMP/MAMP)
# Place project in htdocs/ and access via http://localhost/pos_multi_tienda/

# Check PHP syntax across controllers
php -l application/controllers/*.php

# Check PHP syntax across models
php -l application/models/*.php

# Install dependencies (minimal)
composer install
```

There are no automated tests. Validation is done manually via `healthcheck.php` after deployment.

## Architecture

**Pattern:** Fat controller MVC — business logic lives in controllers (up to 1700 lines each). Models are thin DB-access wrappers (~50-130 lines each).

**Request flow:**
```
.htaccess → index.php → system/core/CodeIgniter.php → application/config/routes.php
→ Controller → Model (DB query) → View
```

**Authentication:** `Auth` controller is the default route. Login calls `Auth_model::verifyLogIn()`, which stores `user_id`, `role_id`, `outlet_id` in CI session. All other controllers should check session at `__construct()`.

**Multi-store:** Every data operation filters by `outlet_id` from session. The `Setting` controller manages outlets, users, and payment methods.

**Session storage:** Database-backed (`ci_sessions` table). Configured in `application/config/config.php`.

## Key Configuration Files

| File | Purpose |
|------|---------|
| `env-config.php` | DB credentials for Hostinger — edit before deploying |
| `application/config/database.php` | Loads env-config.php, uses `getenv()` for credentials |
| `application/config/config.php` | Base URL (auto-detected), session, logging |
| `application/config/routes.php` | Default controller: `Auth` |
| `application/config/autoload.php` | Auto-loaded libraries and helpers |

## Database

- **Driver:** MySQLi
- **Default DB name:** `admin_mutltipos` (or whatever is set in `env-config.php`)
- **Schema:** `install/assets/install.sql` — import this to create all 25 tables
- **Charset:** `utf8mb4` (required for PHP 8 + modern MySQL)

## Security Model

**Password hashing:** `password_hash(PASSWORD_BCRYPT)` for new passwords. Login silently migrates legacy MD5 hashes to bcrypt on first successful login. See `Auth_model::verifyLogIn()`.

**SQL queries:** All `$this->db->query()` calls use CI3 parameterized binding (`?` placeholders with array of values). Active Record methods (`where()`, `get()`, `insert()`) are always safe and preferred.

**CSRF:** Disabled intentionally — enabling it would break the many AJAX endpoints in `Pos.php`. Do not enable without also adding CSRF tokens to all AJAX calls.

## Hostinger Deployment

1. Edit `env-config.php` with real DB credentials
2. Import `install/assets/install.sql` via phpMyAdmin
3. Set PHP 8.2+ in Hostinger hPanel → Advanced → PHP Configuration
4. Upload all files, verify via `https://your-domain.com/healthcheck.php`
5. See `HOSTINGER_SETUP.md` for full step-by-step

After deploy: delete or restrict `/install/` and `/healthcheck.php`.

## CI3 Conventions

- Controllers extend `CI_Controller` (or `MY_Controller` in `application/core/`)
- Models extend `CI_Model` and call `$this->load->database()` in constructor
- Views loaded via `$this->load->view('filename', $data)`
- Input always via `$this->input->post('field')` — never `$_POST` directly
- AJAX responses: `echo json_encode($array); exit;`
