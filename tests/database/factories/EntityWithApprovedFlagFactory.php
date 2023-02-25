<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <anton@komarev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Tests\Laravel\Flag\Database\Factories;

use Cog\Tests\Laravel\Flag\Stubs\Models\Classic\EntityWithApprovedFlag;
use Illuminate\Database\Eloquent\Factories\Factory;

final class EntityWithApprovedFlagFactory extends Factory
{
    protected $model = EntityWithApprovedFlag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'is_approved' => null,
        ];
    }
}
