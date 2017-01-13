![cog-laravel-eloquent-flag-3](https://cloud.githubusercontent.com/assets/1849174/21735581/feb857cc-d47b-11e6-80fa-126be1a1d871.png)

<p align="center">
<a href="https://travis-ci.org/cybercog/laravel-eloquent-flag"><img src="https://img.shields.io/travis/cybercog/laravel-eloquent-flag/master.svg?style=flat-square" alt="Build Status"></a>
<a href="https://styleci.io/repos/69245607"><img src="https://styleci.io/repos/69245607/shield" alt="StyleCI"></a>
<a href="https://github.com/cybercog/laravel-eloquent-flag/releases"><img src="https://img.shields.io/github/release/cybercog/laravel-eloquent-flag.svg?style=flat-square" alt="Releases"></a>
<a href="https://github.com/cybercog/laravel-eloquent-flag/blob/master/LICENSE"><img src="https://img.shields.io/github/license/cybercog/laravel-eloquent-flag.svg?style=flat-square" alt="License"></a>
</p>

## Introduction

Eloquent boolean & timestamp flagged attributes behavior. Enhance eloquent models with commonly used state flags like `Active`, `Published`, `Approved` and others in a minutes!

## Features

- Designed to work with Laravel Eloquent models
- Each model can has as many flags as required
- Each flag adds global query scopes to models
- 2 logical groups of flags: `Classic`, `Inverse`
- 2 types of flags: `Boolean`, `Timestamp`
- Covered with unit tests

## Available flags list

| Trait name | Logic | Database columns | Flag type | Conflict |
| ---------- | ----- | ---------------- | --------- | -------- |
| `HasAcceptedAt` | Classic | `accepted_at` | Timestamp | `HasAcceptedFlag` |
| `HasAcceptedFlag` | Classic | `is_accepted` | Boolean | `HasAcceptedAt` |
| `HasActiveFlag` | Classic | `is_active` | Boolean | - |
| `HasApprovedFlag` | Classic | `is_approved` | Boolean | - |
| `HasClosedAt` | Inverse | `closed_at` | Timestamp | `HasClosedFlag` |
| `HasClosedFlag` | Inverse | `is_closed` | Boolean | `HasClosedAt` |
| `HasExpiredFlag` | Inverse | `is_expired` | Boolean | - |
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

- `Classic` flags displays only entities with `true` or `timestamp` flag value.
- `Inverse` flags displays only entities with `false` or `null` flag value. 

Omitted entities could be retrieved by using special global scope methods, unique for each flag.

## Installation

First, pull in the package through Composer.

```shell
composer require cybercog/laravel-eloquent-flag
```

And then include the service provider within `app/config/app.php`.

*// Service provider not using yet. This step not mandatory. Will be used to boot console commands in future.*

```php
'providers' => [
    Cog\Flag\Providers\FlagServiceProvider::class,
];
```

## Usage

### Prepare database

#### Boolean flag

```php
public function up()
{
    Schema::create('post', function (Blueprint $table) {
        $table->increments('id');
        $table->string('title');
        $table->boolean('is_published');
        $table->timestamps();
    });
}
```

*Change `is_published` on any other `Boolean` flag database column name.*

#### Timestamp flag

```php
public function up()
{
    Schema::create('post', function (Blueprint $table) {
        $table->increments('id');
        $table->string('title');
        $table->timestamp('published_at')->nullable();
        $table->timestamps();
    });
}
```

*Change `published_at` on any other `Timestamp` flag database column name.*

### Setup an activatable model

```php
<?php

namespace App\Models;

use Cog\Flag\Traits\Classic\HasActiveFlag;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasActiveFlag;
}
```

*Model must have boolean `is_active` column in database table.*

### Available functions

#### Get only active models

```php
Post::all();
Post::withoutDeactivated();
```

#### Get only deactivated models

```php
Post::onlyDeactivated();
```

#### Get active + deactivated models

```php
Post::withDeactivated();
```

#### Activate model

```php
Post::where('id', 4)->activate();
```

#### Deactivate model

```php
Post::where('id', 4)->deactivate();
```

### Setup an acceptable model

#### With boolean flag

```php
<?php

namespace App\Models;

use Cog\Flag\Traits\Classic\HasAcceptedFlag;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasAcceptedFlag;
}
```

*Model must have boolean `is_accepted` column in database table.*

#### With timestamp flag

```php
<?php

namespace App\Models;

use Cog\Flag\Traits\Classic\HasAcceptedAt;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasAcceptedAt;
}
```

*Model must have nullable timestamp `accepted_at` column in database table.*

### Available functions

#### Get only accepted models

```php
Post::all();
Post::withoutRejected();
```

#### Get only rejected models

```php
Post::onlyRejected();
```

#### Get accepted + rejected models

```php
Post::withRejected();
```

#### Accept model

```php
Post::where('id', 4)->accept();
```

#### Deactivate model

```php
Post::where('id', 4)->reject();
```

### Setup an approvable model

```php
<?php

namespace App\Models;

use Cog\Flag\Traits\Classic\HasApprovedFlag;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasApprovedFlag;
}
```

*Model must have boolean `is_approved` column in database table.*

### Available functions

#### Get only approved models

```php
Post::all();
Post::withoutDisapproved();
```

#### Get only disapproved models

```php
Post::onlyDisapproved();
```

#### Get approved + disapproved models

```php
Post::withDisapproved();
```

#### Approve model

```php
Post::where('id', 4)->approve();
```

#### Disapprove model

```php
Post::where('id', 4)->disapprove();
```

### Setup a publishable model

#### With boolean flag

```php
<?php

namespace App\Models;

use Cog\Flag\Traits\Classic\HasPublishedFlag;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasPublishedFlag;
}
```

*Model must have boolean `is_published` column in database table.*

#### With timestamp flag

```php
<?php

namespace App\Models;

use Cog\Flag\Traits\Classic\HasPublishedAt;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasPublishedAt;
}
```

*Model must have nullable timestamp `published_at` column in database table.*

### Available functions

#### Get only published models

```php
Post::all();
Post::withoutUnpublished();
```

#### Get only unpublished models

```php
Post::onlyUnpublished();
```

#### Get published + unpublished models

```php
Post::withUnpublished();
```

#### Publish model

```php
Post::where('id', 4)->publish();
```

#### Unpublish model

```php
Post::where('id', 4)->unpublish();
```

### Setup a verifiable model

#### With boolean flag

```php
<?php

namespace App\Models;

use Cog\Flag\Traits\Classic\HasVerifiedFlag;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasVerifiedFlag;
}
```

*Model must have boolean `is_verified` column in database table.*

#### With timestamp flag

```php
<?php

namespace App\Models;

use Cog\Flag\Traits\Classic\HasVerifiedAt;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasVerifiedAt;
}
```

*Model must have nullable timestamp `verified_at` column in database table.*

### Available functions

#### Get only verified models

```php
Post::all();
Post::withoutUnverified();
```

#### Get only unverified models

```php
Post::onlyUnverified();
```

#### Get verified + unverified models

```php
Post::withUnverified();
```

#### Verify model

```php
Post::where('id', 4)->verify();
```

#### Unverify model

```php
Post::where('id', 4)->unverify();
```

### Setup a keepable model

Keep functionality required when you are trying to attach related models before parent one isn't persisted in application.

**Issue:**

1. User press `Create Post` button.
2. Create post form has image uploader.
3. On image uploading user can't attach image to post before post entity wouldn't been stored in database.

**Solution:**

1. Add `HasKeptFlag` trait to model (and add boolean `is_kept` column to model's database table).
2. Create empty model on form loading (it will has `is_kept = 0` by default).
3. Feel free to add any relations to the model.
4. Model will be marked as required to be kept as soon as model will be saved\updated for the first time after creation.

**Known limitations:**

- Using this methodology you wouldn't have create form, only edit will be available.
- Not all the models allows to have empty attributes on save. Such attributes could be set as nullable to allow create blank model.  
- To prevent spam of unkept models in database they could be deleted on a predetermined schedule (once a week for example).

```php
<?php

namespace App\Models;

use Cog\Flag\Traits\Classic\HasKeptFlag;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasKeptFlag;
}
```

Your model is now can be marked to be kept!

*Model must have boolean `is_kept` column in database table.*

By default all records that have a `is_kept` equals to 0 will be excluded from your query results. To include unkept records, all you need to do is call the `withUnkept()` method on your query.

### Available functions

#### Get only kept models

```php
Post::all();
Post::withoutUnkept();
```

#### Get only unkept models

```php
Post::onlyUnkept();
```

#### Get kept + unkept models

```php
Post::withUnkept();
```

#### Keep model

```php
Post::where('id', 4)->keep();
```

#### Unkeep model

```php
Post::where('id', 4)->unkeep();
```

#### Get unkept models which older than hours

```php
Post::onlyUnkeptOlderThanHours(4);
```

Output will have all unkept models created earlier than 4 hours ago.

### Setup an expirable model

```php
<?php

namespace App\Models;

use Cog\Flag\Traits\Inverse\HasExpiredFlag;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasExpiredFlag;
}
```

*Model must have boolean `is_expired` column in database table.*

### Available functions

#### Get only not expired models

```php
Post::all();
Post::withoutExpired();
```

#### Get only expired models

```php
Post::onlyExpired();
```

#### Get expired + not expired models

```php
Post::withExpired();
```

#### Set expire flag to model

```php
Post::where('id', 4)->expire();
```

#### Remove expire flag from model

```php
Post::where('id', 4)->unexpire();
```

### Setup a closable model

#### With boolean flag

```php
<?php

namespace App\Models;

use Cog\Flag\Traits\Inverse\HasClosedFlag;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasClosedFlag;
}
```

*Model must have boolean `is_closed` column in database table.*

#### With timestamp flag

```php
<?php

namespace App\Models;

use Cog\Flag\Traits\Classic\HasClosedAt;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasClosedAt;
}
```

*Model must have nullable timestamp `closed_at` column in database table.*

### Available functions

#### Get only not closed models

```php
Post::all();
Post::withoutClosed();
```

#### Get only closed models

```php
Post::onlyClosed();
```

#### Get closed + not closed models

```php
Post::withClosed();
```

#### Set close flag to model

```php
Post::where('id', 4)->close();
```

#### Remove close flag from model

```php
Post::where('id', 4)->open();
```

## Testing

Run the tests with:

```sh
vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email a.komarev@cybercog.su instead of using the issue tracker.

## Credits

- [Anton Komarev](https://github.com/a-komarev)
- [All Contributors](../../contributors)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Alternatives

*Not found.*

*Feel free to add more alternatives as Pull Request.*

## License

- `Laravel Eloquent Flag` package is open-sourced software licensed under the [MIT license](LICENSE).
- `Check Mark` image licensed under [Creative Commons 3.0](https://creativecommons.org/licenses/by/3.0/us/) by Kimmi Studio.
- `Clock Check` image licensed under [Creative Commons 3.0](https://creativecommons.org/licenses/by/3.0/us/) by Harsha Rai.

## About CyberCog

[CyberCog](http://www.cybercog.ru) is a Social Unity of enthusiasts. Research best solutions in product & software development is our passion.

![cybercog-logo](https://cloud.githubusercontent.com/assets/1849174/18418932/e9edb390-7860-11e6-8a43-aa3fad524664.png)
