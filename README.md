# Laravel Eloquent Flag

[![Build Status](https://img.shields.io/travis/cybercog/laravel-eloquent-flag/master.svg?style=flat-square)](https://travis-ci.org/cybercog/laravel-eloquent-flag)
[![StyleCI](https://styleci.io/repos/69245607/shield)](https://styleci.io/repos/69245607)
[![Releases](https://img.shields.io/github/release/cybercog/laravel-eloquent-flag.svg?style=flat-square)](https://github.com/cybercog/laravel-eloquent-flag/releases)
[![License](https://img.shields.io/github/license/cybercog/laravel-eloquent-flag.svg?style=flat-square)](https://github.com/cybercog/laravel-eloquent-flag/blob/master/LICENSE)

Eloquent flagged attributes behavior.

## Flags list

- Is Active
- Is Published

## Installation

First, pull in the package through Composer.

```shell
composer require cybercog/laravel-eloquent-flag
```

And then include the service provider within `app/config/app.php`.

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

use Cog\Flag\Traits\HasActiveFlag;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasActiveFlag;
}
```

### Available functions

#### Get only active models

```shell
Post::all();
Post::withoutInactive();
```

#### Get only inactive models

```shell
Post::onlyInactive();
```

#### Get active + inactive models

```shell
Post::withInactive();
```

#### Activate model

```shell
Post::where('id', 4)->activate();
```

#### Deactivate model

```shell
Post::where('id', 4)->deactivate();
```

### Setup an publishable model

```php
<?php

namespace App\Models;

use Cog\Flag\Traits\HasPublishedFlag;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasPublishedFlag;
}
```

### Available functions

#### Get only published models

```shell
Post::all();
Post::withoutUnpublished();
```

#### Get only unpublished models

```shell
Post::onlyUnpublished();
```

#### Get published + unpublished models

```shell
Post::withUnpublished();
```

#### Publish model

```shell
Post::where('id', 4)->publish();
```

#### Unpublish model

```shell
Post::where('id', 4)->unpublish();
```

## Testing

Run the tests with:

```shell
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

## License

Please see [License](LICENSE) file for more information.

## About CyberCog

[CyberCog](http://www.cybercog.ru) is a Social Unity of enthusiasts. Research best solutions in product & software development is our passion.

![cybercog-logo](https://cloud.githubusercontent.com/assets/1849174/18418932/e9edb390-7860-11e6-8a43-aa3fad524664.png)
