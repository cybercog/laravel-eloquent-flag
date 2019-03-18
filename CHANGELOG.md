# Change Log

All notable changes to `laravel-eloquent-flag` will be documented in this file.

## [5.0.0] - 2019-03-18

### Added

- Laravel 5.8 support
- ([#48](https://github.com/cybercog/laravel-eloquent-flag/pull/48)) Flag fields auto-casting
- Added `shouldApplyAcceptedAtScope` & `shouldApplyAcceptedFlagScope` methods to control Accepted flags global scope auto apply.
- Added `shouldApplyActiveFlagScope` methods to control Active flag global scope auto apply.
- Added `shouldApplyApprovedAtScope` & `shouldApplyApprovedFlagScope` methods to control Approved flags global scope auto apply.
- Added `shouldApplyClosedAtScope` & `shouldApplyClosedFlagScope` methods to control Closed flags global scope auto apply.

### Changed

- All methods are strict typed now
- `Carbon\Carbon` replaced with `Illuminate\Support\Facades\Date`
- `isRejected` instance method renamed to `isNotAccepted`
- `isDeactivated` instance method renamed to `isNotActivated`
- `isDisapproved` instance method renamed to `isNotApproved`
- `isUninvited` instance method renamed to `isNotInvited`
- `isUnkept` instance method renamed to `isNotKept`
- `isUnpublished` instance method renamed to `isNotPublished`
- `isUnverified` instance method renamed to `isNotVerified`
- `isUnarchived` instance method renamed to `isNotArchived`
- `isOpened` instance method renamed to `isNotClosed`
- `isUndrafted` instance method renamed to `isNotDrafted`
- `isUnended` instance method renamed to `isNotEnded`
- `isUnexpired` instance method renamed to `isNotExpired`
- `reject` instance method renamed to `undoAccept`
- `deactivate` instance method renamed to `undoActivate`
- `disapprove` instance method renamed to `undoApprove`
- `uninvite` instance method renamed to `undoInvite`
- `unkeep` instance method renamed to `undoKeep`
- `unpublish` instance method renamed to `undoPublish`
- `unverify` instance method renamed to `undoVerify`
- `unarchive` instance method renamed to `undoArchive`
- `open` instance method renamed to `undoClose`
- `undraft` instance method renamed to `undoDraft`
- `unend` instance method renamed to `undoEnd`
- `unexpire` instance method renamed to `undoExpire`
- `reject` global scope method renamed to `undoAccept`
- `withRejected` global scope method renamed to `withNotAccepted`
- `withoutRejected` global scope method renamed to `withoutNotAccepted`
- `onlyRejected` global scope method renamed to `onlyNotAccepted`
- `deactivate` global scope method renamed to `undoActivate`
- `withDeactivated` global scope method renamed to `withNotActivated`
- `withoutDeactivated` global scope method renamed to `withoutNotActivated`
- `onlyDeactivated` global scope method renamed to `onlyNotActivated`
- `disapprove` global scope method renamed to `undoApprove`
- `withDisapproved` global scope method renamed to `withNotApproved`
- `withoutDisapproved` global scope method renamed to `withoutNotApproved`
- `onlyDisapproved` global scope method renamed to `onlyNotApproved`
- `uninvite` global scope method renamed to `undoInvite`
- `withUninvited` global scope method renamed to `withNotInvited`
- `withoutUninvited` global scope method renamed to `withoutNotInvited`
- `onlyUninvited` global scope method renamed to `onlyNotInvited`
- `unkeep` global scope method renamed to `undoKeep`
- `withUnkept` global scope method renamed to `withNotKept`
- `withoutUnkept` global scope method renamed to `withoutNotKept`
- `onlyUnkept` global scope method renamed to `onlyNotKept`
- `unpublish` global scope method renamed to `undoPublish`
- `withUnpublished` global scope method renamed to `withNotPublished`
- `withoutUnpublished` global scope method renamed to `withoutNotPublished`
- `onlyUnpublished` global scope method renamed to `onlyNotPublished`
- `unverify` global scope method renamed to `undoVerify`
- `withUnverified` global scope method renamed to `withNotVerified`
- `withoutUnverified` global scope method renamed to `withoutNotVerified`
- `onlyUnverified` global scope method renamed to `onlyNotVerified`
- `unarchive` global scope method renamed to `undoArchive`
- `open` global scope method renamed to `undoClose`
- `undraft` global scope method renamed to `undoDraft`
- `unend` global scope method renamed to `undoEnd`
- `unexpire` global scope method renamed to `undoExpire`
- `rejected` model event renamed to `acceptedUndone`
- `deactivated` model event renamed to `activatedUndone`
- `disapproved` model event renamed to `approvedUndone`
- `uninvited` model event renamed to `invitedUndone`
- `unkept` model event renamed to `keptUndone`
- `unpublished` model event renamed to `publishedUndone`
- `unverified` model event renamed to `verifiedUndone`
- `unarchived` model event renamed to `archivedUndone`
- `opened` model event renamed to `closedUndone`
- `undrafted` model event renamed to `draftedUndone`
- `unended` model event renamed to `endedUndone`
- `unexpired` model event renamed to `expiredUndone`

### Removed

- Dropped PHP 5.6, 7.0 support
- Dropped Laravel 5.2, 5.3, 5.4, 5.5, 5.6, 5.7 support
- ([#50](https://github.com/cybercog/laravel-eloquent-flag/pull/50)) Removed attribute mutator `set*` & `unset*` methods from all helper classes
- ([#56](https://github.com/cybercog/laravel-eloquent-flag/pull/56)) Removed global scopes auto-apply

## [4.0.0] - 2018-09-09

### Added

- ([#42](https://github.com/cybercog/laravel-eloquent-flag/pull/42)) Laravel 5.7 support
- ([#37](https://github.com/cybercog/laravel-eloquent-flag/pull/37)) Events firing

## [3.13.0] - 2018-02-08

### Added

- Laravel 5.6 support ([#35](https://github.com/cybercog/laravel-eloquent-flag/pull/35)).
- `is_invited` classic boolean flag added ([#31](https://github.com/cybercog/laravel-eloquent-flag/pull/31)).
- `invited_at` classic timestamp flag added ([#31](https://github.com/cybercog/laravel-eloquent-flag/pull/31)).
- `is_ended` inverse boolean flag added ([#31](https://github.com/cybercog/laravel-eloquent-flag/pull/31)).
- `ended_at` inverse timestamp flag added ([#31](https://github.com/cybercog/laravel-eloquent-flag/pull/31)).
- `is_drafted` inverse boolean flag added ([#32](https://github.com/cybercog/laravel-eloquent-flag/pull/32)).
- `drafted_at` inverse timestamp flag added ([#32](https://github.com/cybercog/laravel-eloquent-flag/pull/32)).
- `is_archived` inverse boolean flag added ([#32](https://github.com/cybercog/laravel-eloquent-flag/pull/32)).
- `archived_at` inverse timestamp flag added ([#32](https://github.com/cybercog/laravel-eloquent-flag/pull/32)).

## [3.12.0] - 2017-09-09

### Added

- Laravel 5.5 support.

## [3.11.0] - 2017-02-20

### Added

- Laravel 5.4 support.

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

[5.0.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/4.0.0...5.0.0
[4.0.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/3.13.0...4.0.0
[3.13.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/3.12.0...3.13.0
[3.12.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/3.11.0...3.12.0
[3.11.0]: https://github.com/cybercog/laravel-eloquent-flag/compare/3.10.0...3.11.0
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
