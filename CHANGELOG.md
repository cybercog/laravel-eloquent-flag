# Changelog

All notable changes to `laravel-eloquent-flag` will be documented in this file.

## 3.0.0 - 2017-01-07

### Added

- `Has{Name}FlagScope` traits which include global scopes.
- `Has{Name}FlagHelpers` traits which include flag related helper methods.
- `Has{Name}FlagBehavior` traits which include flag specific behavior.

### Changed

- Each Flag trait was spliced on 2 additional traits: `Has{Name}Flag` = `Has{Name}FlagScope` + `Has{Name}FlagHelpers`.
- Kept Flag trait was spliced on 3 additional traits, because events were pulled out to `HasKeptFlagBehavior` trait.
- Flags `Classic\Accepted`, `Classic\Active` & `Classic\Approved` methods were changed. Details in the [Upgrade Guide](UPGRADE.md).

## 2.1.0 - 2017-01-04

- `is_closed` inverse boolean flag added.

## 2.0.0 - 2017-01-04

### Breaking changes

- Namespaces of flag's traits received `Classic` at the end: `Cog\Flag\Traits\Classic`.
- Namespaces of flag's scopes received `Classic` at the end: `Cog\Flag\Scopes\Classic`.

### Added

- `Inverse Logic` flags group. Hides entities if flag not set.
- `is_expired` inverse boolean flag added.

## 1.5.0 - 2016-12-31

- `is_approved` boolean flag added.

## 1.4.0 - 2016-12-26

- `is_verified` boolean flag added.

## 1.3.0 - 2016-12-14

- `is_accepted` boolean flag added.

## 1.2.0 - 2016-12-10

- `is_kept` boolean flag added.

## 1.1.0 - 2016-09-25

- `is_published` boolean flag added.

## 1.0.0 - 2016-09-25

- `is_active` boolean flag added.
