# AGENTS.md

This file provides guidance to LLM Agents when working with code in this repository.

## Project Overview

Laravel Eloquent Flag is a PHP package (`cybercog/laravel-eloquent-flag`) that adds boolean and timestamp flagged attribute behaviors to Eloquent models. Provides state flags (Active, Published, Approved, Expired, etc.) with auto-applied global query scopes. Pure trait-based package with no service provider. Supports Laravel 9-13 and PHP 8.0-8.5.

## Commands

All commands run through Docker. Services: `php81`, `php82`, `php83`, `php84`, `php85`.

```bash
# Build and start containers
docker compose up -d --build

# Install dependencies
docker compose exec php85 composer install

# Run all tests (uses in-memory SQLite)
docker compose exec php85 composer test

# Run a single test file
docker compose exec php85 vendor/bin/phpunit tests/Unit/Scopes/Classic/PublishedFlagScopeTest.php

# Run a single test method
docker compose exec php85 vendor/bin/phpunit --filter test_it_can_publish_model

# Run tests in a subdirectory
docker compose exec php85 vendor/bin/phpunit tests/Unit/Scopes/Classic/
```

## Namespaces & Autoloading

- `Cog\Flag\` → `src/` (source)
- `Cog\Tests\Laravel\Flag\` → `tests/` (tests)

## Architecture

### Two Dimensions

**Flag type:** Boolean (`HasXxxFlag`, stores `is_xxx` as bool) vs Timestamp (`HasXxxAt`, stores `xxx_at` as nullable datetime).

**Scope direction:** Classic (default query shows flagged-true/not-null records) vs Inverse (default query shows flagged-false/null records).

### Per-Flag File Structure (4 source files)

Each flag (e.g., "Published") consists of:

1. **`src/Traits/{Classic|Inverse}/HasPublishedFlag.php`** — Main user-facing trait, composes Helpers + Scope traits.
2. **`src/Traits/{Classic|Inverse}/HasPublishedFlagHelpers.php`** — `initializeHas...Helpers()` for attribute casting, `isPublished()`/`isNotPublished()`, `publish()`/`undoPublish()` with model events.
3. **`src/Traits/{Classic|Inverse}/HasPublishedFlagScope.php`** — `bootHas...Scope()` registers the global scope.
4. **`src/Scopes/{Classic|Inverse}/PublishedFlagScope.php`** — Global scope implementing `apply()` (conditional via `shouldApplyXxxScope()`) and `extend()` (query builder macros like `withNotPublished()`, `onlyNotPublished()`).

### Scope Application is Opt-in

Scopes only filter queries when the model implements `shouldApplyXxxScope(): bool` returning `true`. Without it, all records are returned.

### Special Case: HasKeptFlag

Has an additional `HasKeptFlagBehavior` trait that auto-sets `is_kept = false` on creating and `is_kept = true` on updating.

## Adding a New Flag

Source files (4):
- `src/Scopes/{Classic|Inverse}/XxxScope.php`
- `src/Traits/{Classic|Inverse}/HasXxx.php`
- `src/Traits/{Classic|Inverse}/HasXxxHelpers.php`
- `src/Traits/{Classic|Inverse}/HasXxxScope.php`

Test files (5+ locations):
- `tests/database/migrations/` — table migration
- `tests/database/factories/` — model factory
- `tests/Stubs/Models/{Classic|Inverse}/` — 3 stub models (base, Applied, Unapplied)
- `tests/Unit/Scopes/{Classic|Inverse}/` — scope tests
- `tests/Unit/Traits/{Classic|Inverse}/` — helper tests

Follow existing flag implementations as templates. All scope classes and test classes are `final`.

## Testing

Tests use Orchestra Testbench with in-memory SQLite. The base `TestCase` class (`tests/TestCase.php`) handles migrations and factory registration. Test stubs live in `tests/Stubs/Models/` and factories in `tests/database/factories/`.

## Code Conventions

- All PHP files use `declare(strict_types=1)`.
- All files include the copyright header block.
- PSR-12 coding style (StyleCI with Laravel preset).
- Test methods use `test_it_` prefix with snake_case.
- Model events fired: `'{action}'` (e.g., `'published'`) and `'{action}Undone'` (e.g., `'publishedUndone'`).
