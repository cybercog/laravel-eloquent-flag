<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) CyberCog <support@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$factory->define(\Cog\Flag\Tests\Stubs\Models\Inverse\EntityWithClosedFlag::class, function (\Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'is_closed' => true,
    ];
});
