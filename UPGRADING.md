# Upgrade Guide

- [Upgrading From 2.0 To 3.0](#upgrade-3.0)
- [Upgrading From 1.0 To 2.0](#upgrade-2.0)

<a name="upgrade-3.0"></a>
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

<a name="upgrade-2.0"></a>
## Upgrading From 1.0 To 2.0

- Namespaces of flag's traits received `Classic` at the end: `Cog\Flag\Traits\Classic`.
- Namespaces of flag's scopes received `Classic` at the end: `Cog\Flag\Scopes\Classic`.
