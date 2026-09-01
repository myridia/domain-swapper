# AGENTS.md — domain-swapper

## What this is
WordPress plugin to serve the same WordPress site from multiple domain names (e.g. dk.foo.com, de.foo.com).

## Stack
- PHP (>=5.2.4)
- WordPress (>=3.0.1)
- Docker (for testing)

## Run
```bash
cd dockers
docker-compose up
```
WordPress at http://127.0.0.1:8080, user: test, pass: test

## Structure
- `domain-swapper/` — WordPress plugin (PHP)
  - `domain-swapper.php` — main plugin file
  - `src/` — PHP source
  - `js/` — JavaScript
  - `languages/` — i18n files
  - `assets/` — static assets
- `test/` — Docker test environment
- `pages/` — plugin page assets

## Conventions
- No comments in code unless asked.
- Verify: `php -l domain-swapper/domain-swapper.php`
