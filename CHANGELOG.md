# Change Log

All notable changes to `laravel-eloquent-flag` will be documented in this file.

## [3.10.0] - 2017-02-13

### Added

- `shouldApplyVerifiedAtScope` & `shouldApplyVerifiedFlagScope` methods to skip Verified flags global scope auto apply.

## [3.9.0] - 2017-02-03

### Added

- `shouldApplyExpiredAtScope` & `shouldApplyExpiredFlagScope` methods to skip Expired flags global scope auto apply.

## [3.8.0] - 2017-01-29

### Added

- `shouldApplyPublishedAtScope` & `shouldApplyPublishedFlagScope` methods to skip Published flags global scope auto apply.

## [3.7.0] - 2017-01-14

### Added

- `setKeptOnUpdate` property in `HasKeptFlagBehavior` to control events.

### Changed

- `HasAcceptedAtHelpers` methods implemented.
- `HasAcceptedFlagHelpers` methods implemented.
- `HasActiveFlagHelpers` methods implemented.
- `HasKeptFlagHelpers` methods implemented.
- `HasPublishedAtHelpers` methods implemented.
- `HasPublishedFlagHelpers` methods implemented.

## [3.6.0] - 2017-01-14

### Added

- `expired_at` inverse timestamp flag added.

### Changed

- `is_expired` inverse boolean flag helpers implemented.

## [3.5.0] - 2017-01-13

### Added

- `approved_at` classic timestamp flag added.

### Changed

- `is_approved` classic boolean flag helpers implemented.

## [3.4.0] - 2017-01-13

### Added

- `closed_at` inverse timestamp flag added.

### Changed

- `is_closed` inverse boolean flag helpers added.

## [3.3.0] - 2017-01-12

### Added

- `verified_at` classic timestamp flag added.
- `is_verified` classic boolean flag helpers added.

## [3.2.0] - 2017-01-12

### Added

- `accepted_at` classic timestamp flag added.

## [3.1.0] - 2017-01-11

### Added

- `Timestamp` flag types introduced.
- `published_at` classic timestamp flag added.

## [3.0.0] - 2017-01-07

### Added

- `Has{Name}FlagScope` traits which include global scopes.
- `Has{Name}FlagHelpers` traits which include flag related helper methods.
- `Has{Name}FlagBehavior` traits which include flag specific behavior.

### Changed

- Each Flag trait was spliced on 2 additional traits: `Has{Name}Flag` = `Has{Name}FlagScope` + `Has{Name}FlagHelpers`.
- Kept Flag trait was spliced on 3 additional traits, because events were pulled out to `HasKeptFlagBehavior` trait.
- Flags `Classic\Accepted`, `Classic\Active` & `Classic\Approved` methods were changed. Details in the [Upgrade Guide](UPGRADE.md).

## [2.1.0] - 2017-01-04

- `is_closed` inverse boolean flag added.

## [2.0.0] - 2017-01-04

### Breaking changes

- Namespaces of flag's traits received `Classic` at the end: `Cog\Flag\Traits\Classic`.
- Namespaces of flag's scopes received `Classic` at the end: `Cog\Flag\Scopes\Classic`.

### Added

- `Inverse Logic` flags group. Hides entities if flag not set.
- `is_expired` inverse boolean flag added.

## [1.5.0] - 2016-12-31

- `is_approved` boolean flag added.

## [1.4.0] - 2016-12-26

- `is_verified` boolean flag added.

## [1.3.0] - 2016-12-14

- `is_accepted` boolean flag added.

## [1.2.0] - 2016-12-10

- `is_kept` boolean flag added.

## [1.1.0] - 2016-09-25

- `is_published` boolean flag added.

## 1.0.0 - 2016-09-25

- `is_active` boolean flag added.

[3.10.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/3.9.0...3.10.0
[3.9.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/3.8.0...3.9.0
[3.8.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/3.7.0...3.8.0
[3.7.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/3.6.0...3.7.0
[3.6.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/3.5.0...3.6.0
[3.5.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/3.4.0...3.5.0
[3.4.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/3.3.0...3.4.0
[3.3.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/3.2.0...3.3.0
[3.2.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/3.1.0...3.2.0
[3.1.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/3.0.0...3.1.0
[3.0.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/2.1.0...3.0.0
[2.1.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/2.0.0...2.1.0
[2.0.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/1.5.0...2.0.0
[1.5.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/1.4.0...1.5.0
[1.4.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/1.3.0...1.4.0
[1.3.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/1.2.0...1.3.0
[1.2.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/1.1.0...1.2.0
[1.1.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/1.0.0...1.1.0
