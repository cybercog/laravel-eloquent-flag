<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$factory->define(\Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithExpiredAt::class, function (\Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'expired_at' => null,
    ];
});
