<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <anton@komarev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use Cog\Tests\Laravel\Flag\Stubs\Models\Classic\EntityWithPublishedFlag;
use Faker\Generator as Faker;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(EntityWithPublishedFlag::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'is_published' => false,
    ];
});
