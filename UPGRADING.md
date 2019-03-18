# Upgrade Guide

- [Upgrading From 4.0 To 5.0](#upgrading-from-40-to-50)
- [Upgrading From 2.0 To 3.0](#upgrading-from-20-to-30)
- [Upgrading From 1.0 To 2.0](#upgrading-from-10-to-20)

## Upgrading From 4.0 To 5.0

You can upgrade from v4 to v5 by performing these renames in your model that uses flags.

These instance methods should be renamed:

- `isRejected` renamed to `isNotAccepted`
- `isDeactivated` renamed to `isNotActivated`
- `isDisapproved` renamed to `isNotApproved`
- `isUninvited` renamed to `isNotInvited`
- `isUnkept` renamed to `isNotKept`
- `isUnpublished` renamed to `isNotPublished`
- `isUnverified` renamed to `isNotVerified`
- `isUnarchived` renamed to `isNotArchived`
- `isOpened` renamed to `isNotClosed`
- `isUndrafted` renamed to `isNotDrafted`
- `isUnended` renamed to `isNotEnded`
- `isUnexpired` renamed to `isNotExpired`
- `reject` renamed to `undoAccept`
- `deactivate` renamed to `undoActivate`
- `disapprove` renamed to `undoApprove`
- `uninvite` renamed to `undoInvite`
- `unkeep` renamed to `undoKeep`
- `unpublish` renamed to `undoPublish`
- `unverify` renamed to `undoVerify`
- `unarchive` renamed to `undoArchive`
- `open` renamed to `undoClose`
- `undraft` renamed to `undoDraft`
- `unend` renamed to `undoEnd`
- `unexpire` renamed to `undoExpire`

These global scopes methods should be renamed:

- `reject` method renamed to `undoAccept`
- `withRejected` method renamed to `withNotAccepted`
- `withoutRejected` method renamed to `withoutNotAccepted`
- `onlyRejected` method renamed to `onlyNotAccepted`
- `deactivate` method renamed to `undoActivate`
- `withDeactivated` method renamed to `withNotActivated`
- `withoutDeactivated` method renamed to `withoutNotActivated`
- `onlyDeactivated` method renamed to `onlyNotActivated`
- `disapprove` method renamed to `undoApprove`
- `withDisapproved` method renamed to `withNotApproved`
- `withoutDisapproved` method renamed to `withoutNotApproved`
- `onlyDisapproved` method renamed to `onlyNotApproved`
- `uninvite` method renamed to `undoInvite`
- `withUninvited` method renamed to `withNotInvited`
- `withoutUninvited` method renamed to `withoutNotInvited`
- `onlyUninvited` method renamed to `onlyNotInvited`
- `unkeep` method renamed to `undoKeep`
- `withUnkept` method renamed to `withNotKept`
- `withoutUnkept` method renamed to `withoutNotKept`
- `onlyUnkept` method renamed to `onlyNotKept`
- `unpublish` method renamed to `undoPublish`
- `withUnpublished` method renamed to `withNotPublished`
- `withoutUnpublished` method renamed to `withoutNotPublished`
- `onlyUnpublished` method renamed to `onlyNotPublished`
- `unverify` method renamed to `undoVerify`
- `withUnverified` method renamed to `withNotVerified`
- `withoutUnverified` method renamed to `withoutNotVerified`
- `onlyUnverified` method renamed to `onlyNotVerified`
- `unarchive` method renamed to `undoArchive`
- `open` method renamed to `undoClose`
- `undraft` method renamed to `undoDraft`
- `unend` method renamed to `undoEnd`
- `unexpire` method renamed to `undoExpire`

These events names should be renamed:

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

## Upgrading From 2.0 To 3.0

You can upgrade from v2 to v3 by performing these renames in your model that has flags: `Accepted`, `Active` & `Approved`.

These methods should be renamed:

- `unaccept()` has been renamed to `reject()`.
- `withUnaccepted()` has been renamed to `withRejected()`.
- `withoutUnaccepted()` has been renamed to `withoutRejected()`.
- `onlyUnaccepted()` has been renamed to `onlyRejected()`.
- `withInactive()` has been renamed to `withDeactivated()`.
- `withoutInactive()` has been renamed to `withoutDeactivated()`.
- `onlyInactive()` has been renamed to `onlyDeactivated()`.
- `unapprove()` has been renamed to `disapprove()`.
- `withUnapproved()` has been renamed to `withDisapproved()`.
- `withoutUnapproved()` has been renamed to `withoutDisapproved()`.
- `onlyUnapproved()` has been renamed to `onlyDisapproved()`.

## Upgrading From 1.0 To 2.0

- Namespaces of flag's traits received `Classic` at the end: `Cog\Flag\Traits\Classic`.
- Namespaces of flag's scopes received `Classic` at the end: `Cog\Flag\Scopes\Classic`.
