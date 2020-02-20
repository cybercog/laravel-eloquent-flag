# Laravel Eloquent Flag

![cog-laravel-eloquent-flag](https://user-images.githubusercontent.com/1849174/53454214-7d38d680-3a37-11e9-953d-8daee98fb087.png)

<p align="center">
<a href="https://github.com/cybercog/laravel-eloquent-flag/releases"><img src="https://img.shields.io/github/release/cybercog/laravel-eloquent-flag.svg?style=flat-square" alt="Releases"></a>
<a href="https://travis-ci.org/cybercog/laravel-eloquent-flag"><img src="https://img.shields.io/travis/cybercog/laravel-eloquent-flag/master.svg?style=flat-square" alt="Build Status"></a>
<a href="https://styleci.io/repos/69245607"><img src="https://styleci.io/repos/69245607/shield" alt="StyleCI"></a>
<a href="https://scrutinizer-ci.com/g/cybercog/laravel-eloquent-flag/?branch=master"><img src="https://img.shields.io/scrutinizer/g/cybercog/laravel-eloquent-flag.svg?style=flat-square" alt="Code Quality"></a>
<a href="https://github.com/cybercog/laravel-eloquent-flag/blob/master/LICENSE"><img src="https://img.shields.io/github/license/cybercog/laravel-eloquent-flag.svg?style=flat-square" alt="License"></a>
</p>

## Introduction

Eloquent boolean & timestamp flagged attributes behavior. Enhance Eloquent Models with commonly used state flags like `Active`, `Published`, `Approved` and others in a minutes!

## Contents

- [Features](#features)
- [Available flags list](#available-flags-list)
- [How it works](#how-it-works)
- [Installation](#installation)
- [Usage](#usage)
- [Changelog](#changelog)
- [Upgrading](#upgrading)
- [Contributing](#contributing)
- [Testing](#testing)
- [Security](#security)
- [Contributors](#contributors)
- [Alternatives](#alternatives)
- [License](#license)
- [About CyberCog](#about-cybercog)

## Features

- Designed to work with Laravel Eloquent models.
- Each model can have many flags.
- Each flag adds global query scopes to models.
- 2 logical groups of flags: `Classic`, `Inverse`.
- 2 types of flags: `Boolean`, `Timestamp`.
- Flag fields auto-casting to `bool` & `DateTime`.
- Following PHP Standard Recommendations:
  - [PSR-1 (Basic Coding Standard)](http://www.php-fig.org/psr/psr-1/).
  - [PSR-2 (Coding Style Guide)](http://www.php-fig.org/psr/psr-2/).
  - [PSR-4 (Autoloading Standard)](http://www.php-fig.org/psr/psr-4/).
- Covered with unit tests.

## Available flags list

| Trait name | Logic | Database column | Flag type | Conflict |
| ---------- | ----- | ---------------- | --------- | -------- |
| `HasAcceptedAt` | Classic | `accepted_at` | Timestamp | `HasAcceptedFlag` |
| `HasAcceptedFlag` | Classic | `is_accepted` | Boolean | `HasAcceptedAt` |
| `HasActiveFlag` | Classic | `is_active` | Boolean | - |
| `HasApprovedAt` | Classic | `approved_at` | Timestamp | `HasApprovedFlag` |
| `HasApprovedFlag` | Classic | `is_approved` | Boolean | `HasApprovedAt` |
| `HasArchivedAt` | Inverse | `archived_at` | Timestamp | `HasArchivedFlag` |
| `HasArchivedFlag` | Inverse | `is_archived` | Boolean | `HasArchivedAt` |
| `HasClosedAt` | Inverse | `closed_at` | Timestamp | `HasClosedFlag` |
| `HasClosedFlag` | Inverse | `is_closed` | Boolean | `HasClosedAt` |
| `HasDraftedAt` | Inverse | `drafted_at` | Timestamp | `HasDraftedFlag` |
| `HasDraftedFlag` | Inverse | `is_drafted` | Boolean | `HasDraftedAt` |
| `HasEndedAt` | Inverse | `ended_at` | Timestamp | `HasEndedFlag` |
| `HasEndedFlag` | Inverse | `is_ended` | Boolean | `HasEndedAt` |
| `HasExpiredAt` | Inverse | `expired_at` | Timestamp | `HasExpiredFlag` |
| `HasExpiredFlag` | Inverse | `is_expired` | Boolean | `HasExpiredAt` |
| `HasInvitedAt` | Classic | `invited_at` | Timestamp | `HasInvitedFlag` |
| `HasInvitedFlag` | Classic | `is_invited` | Boolean | `HasInvitedAt` |
| `HasKeptFlag` | Classic | `is_kept` | Boolean | - |
| `HasPublishedAt` | Classic | `published_at` | Timestamp | `HasPublishedFlag` |
| `HasPublishedFlag` | Classic | `is_published` | Boolean | `HasPublishedAt` |
| `HasVerifiedAt` | Classic | `verified_at` | Timestamp | `HasVerifiedFlag` |
| `HasVerifiedFlag` | Classic | `is_verified` | Boolean | `HasVerifiedAt` |

Any entity can has more than one flag at the same time. If flags can't work for the same entity simultaneously they are listed in `Conflict` column.

## How it works

Eloquent Flag is an easy way to add flagged attributes to eloquent models. All flags has their own trait which adds global scopes to desired entity.

There are 2 types of flags:

- `Boolean` flags are the common ones. Stored in database as `BOOLEAN` or `TINYINT(1)` value.
- `Timestamp` flags represented in database as nullable `TIMESTAMP` column. Useful when you need to know when action was performed.

All flags separated on 2 logical groups:

- `Classic` flags displays only entities with `true` or `timestamp` flag value by default.
- `Inverse` flags displays only entities with `false` or `null` flag value by default.

Omitted entities could be retrieved by using special global scope methods, unique for each flag.

> **Example:** If your `Article` model has `PublishedAt` flag then `Article::get()` will return you only published records. When you need to get only unpublished records you could call `Article::onlyUnpublished()->get()` and `Article::withUnpublished()->get()` will return you published and unpublished articles as well.

Helper traits will automatically cast flag attributes to a `DateTime` / `Carbon` instance or `bool` for you.

## Installation

Pull in the package through Composer.

```shell script
$ composer require cybercog/laravel-eloquent-flag
```

## Usage

[Usage examples described in Wiki](https://github.com/cybercog/laravel-eloquent-flag/wiki/usage)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Upgrading

Please see [UPGRADING](UPGRADING.md) for detailed upgrade instructions.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Testing

Run the tests with:

```shell script
$ vendor/bin/phpunit
```

## Security

If you discover any security related issues, please email open@cybercog.su instead of using the issue tracker.

## Contributors

| <a href="https://github.com/antonkomarev">![@antonkomarev](https://avatars.githubusercontent.com/u/1849174?s=110)<br />Anton Komarev</a> | <a href="https://github.com/zagreusinoz">![@zagreusinoz](https://avatars.githubusercontent.com/u/16147285?s=110)<br />zagreusinoz</a> | <a href="https://github.com/jonagoldman">![@jonagoldman](https://avatars.githubusercontent.com/u/1297559?s=110)<br />Jona Goldman</a> | <a href="https://github.com/irazasyed">![@irazasyed](https://avatars.githubusercontent.com/u/1915268?s=110)<br />Irfaq Syed</a> | <a href="https://github.com/gpioto">![@gpioto](https://avatars.githubusercontent.com/u/7549089?s=110)<br />gpioto</a> |  
| :---: | :---: | :---: | :---: | :---: |
| <a href="https://github.com/rayronvictor">![@rayronvictor](https://avatars.githubusercontent.com/u/1683922?s=110)<br />Rayron Victor</a> | | | | |

[Eloquent Flag contributors list](../../contributors)

## Alternatives

*Feel free to add more alternatives as Pull Request.*

## License

- `Laravel Eloquent Flag` package is open-sourced software licensed under the [MIT license](LICENSE) by [Anton Komarev].
- `Clock` image licensed under [Creative Commons 3.0](https://creativecommons.org/licenses/by/3.0/us/) by Rudez Studio.

## About CyberCog

[CyberCog](https://cybercog.su) is a Social Unity of enthusiasts. Research best solutions in product & software development is our passion.

- [Follow us on Twitter](https://twitter.com/cybercog)
- [Read our articles on Medium](https://medium.com/cybercog)

<a href="https://cybercog.su"><img src="https://cloud.githubusercontent.com/assets/1849174/18418932/e9edb390-7860-11e6-8a43-aa3fad524664.png" alt="CyberCog"></a>

[Anton Komarev]: https://komarev.com
