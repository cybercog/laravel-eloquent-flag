# Laravel Eloquent Flag

[![Build Status](https://img.shields.io/travis/cybercog/laravel-eloquent-flag/master.svg?style=flat-square)](https://travis-ci.org/cybercog/laravel-eloquent-flag)
[![StyleCI](https://styleci.io/repos/69245607/shield)](https://styleci.io/repos/69245607)
[![Releases](https://img.shields.io/github/release/cybercog/laravel-eloquent-flag.svg?style=flat-square)](https://github.com/cybercog/laravel-eloquent-flag/releases)
[![License](https://img.shields.io/github/license/cybercog/laravel-eloquent-flag.svg?style=flat-square)](https://github.com/cybercog/laravel-eloquent-flag/blob/master/LICENSE)

Eloquent flagged attributes behavior. Add commonly used flags to models very quick and easy.

![cog-laravel-eloquent-flag](https://cloud.githubusercontent.com/assets/1849174/21166452/b1bbf3e8-c1b6-11e6-8f06-468828402ebe.png)

## Features

- Designed to work with Laravel Eloquent models
- Each model can has as many flags as required
- Each flag adds global query scopes to models
- Covered with unit tests

## Available flags list

| Trait name | Logic | Database columns | Flag type |
| ---------- | ----- | ---------------- | --------- |
| `HasAcceptedFlag` | Classic | `is_accepted` | Boolean |
| `HasActiveFlag` | Classic | `is_active` | Boolean |
| `HasApprovedFlag` | Classic | `is_approved` | Boolean |
| `HasClosedFlag` | Inverse | `is_closed` | Boolean |
| `HasExpiredFlag` | Inverse | `is_expired` | Boolean |
| `HasKeptFlag` | Classic | `is_kept` | Boolean |
| `HasPublishedFlag` | Classic | `is_published` | Boolean |
| `HasVerifiedFlag` | Classic | `is_verified` | Boolean |

## How it works

Eloquent Flag is an easy way to add flagged attributes to eloquent models. All flags has their own trait which adds global scopes to desired entity.

All flags separated on 2 logical groups:

- `Classic` flags displays only entities with flag setted as `true`.
- `Inverse` flags displays only entities with flag setted as `false`. 

Omitted entities could be retrieved by using special global scope methods, unique for each flag.

## Installation

First, pull in the package through Composer.

```shell
composer require cybercog/laravel-eloquent-flag
```

And then include the service provider within `app/config/app.php`.

*// Service provider not using yet. Will be used to boot console commands in future.*

```php
'providers' => [
    Cog\Flag\Providers\FlagServiceProvider::class,
];
```

## Usage

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
Post::withoutInactive();
```

#### Get only inactive models

```php
Post::onlyInactive();
```

#### Get active + inactive models

```php
Post::withInactive();
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

### Available functions

#### Get only accepted models

```php
Post::all();
Post::withoutUnaccepted();
```

#### Get only unaccepted models

```php
Post::onlyUnaccepted();
```

#### Get accepted + unaccepted models

```php
Post::withUnaccepted();
```

#### Accept model

```php
Post::where('id', 4)->accept();
```

#### Deactivate model

```php
Post::where('id', 4)->unaccept();
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
Post::withoutUnapproved();
```

#### Get only unapproved models

```php
Post::onlyUnapproved();
```

#### Get approved + unapproved models

```php
Post::withUnapproved();
```

#### Approve model

```php
Post::where('id', 4)->approve();
```

#### Unapprove model

```php
Post::where('id', 4)->unapprove();
```

### Setup a publishable model

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
Post::where('id', 4)->unclose();
```

## Testing

Run the tests with:

```sh
vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email support@cybercog.su instead of using the issue tracker.

## Credits

- [Anton Komarev](https://github.com/a-komarev)
- [All Contributors](../../contributors)

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
