<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Tests\Unit\Traits\Classic;

use Carbon\Carbon;
use Cog\Flag\Tests\Stubs\Models\Classic\EntityWithKeptFlag;
use Cog\Flag\Tests\TestCase;

/**
 * Class HasKeptFlagHelperTest.
 *
 * @package Cog\Flag\Tests\Unit\Traits\Classic
 */
class HasKeptFlagHelperTest extends TestCase
{
    /** @test */
    public function it_can_check_if_entity_is_kept()
    {
        $entity = factory(EntityWithKeptFlag::class, 1)->create([
            'is_kept' => true,
        ]);

        $this->assertTrue($entity->isKept());
    }

    /** @test */
    public function it_can_get_unkept_older_than_hours()
    {
        factory(EntityWithKeptFlag::class, 3)->create([
            'is_kept' => true,
            'created_at' => Carbon::now()->subHours(4)->toDateTimeString(),
        ]);
        factory(EntityWithKeptFlag::class, 2)->create([
            'is_kept' => false,
            'created_at' => Carbon::now()->subHours(4)->toDateTimeString(),
        ]);
        factory(EntityWithKeptFlag::class, 2)->create([
            'is_kept' => false,
            'created_at' => Carbon::now()->subHours(2)->toDateTimeString(),
        ]);
        factory(EntityWithKeptFlag::class, 2)->create([
            'is_kept' => false,
        ]);

        $entities = EntityWithKeptFlag::onlyUnkeptOlderThanHours(4)->get();

        $this->assertCount(2, $entities);
    }
}
