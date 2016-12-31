<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) CyberCog <support@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Tests\Unit\Traits;

use Carbon\Carbon;
use Cog\Flag\Tests\TestCase;
use Cog\Flag\Tests\Stubs\Models\EntityWithKeptFlag;

/**
 * Class HasKeptFlagTest.
 *
 * @package Cog\Flag\Tests\Unit\Traits
 */
class HasKeptFlagTest extends TestCase
{
    /** @test */
    public function it_sets_is_kept_false_on_create()
    {
        $entity = new EntityWithKeptFlag([
            'name' => 'test',
        ]);
        $entity->save();

        $this->assertFalse($entity->is_kept);
    }

    /** @test */
    public function it_sets_is_kept_true_on_any_update()
    {
        $entity = factory(EntityWithKeptFlag::class)->create([
            'is_kept' => false,
        ]);

        $entity->update([
            'name' => 'new-name',
        ]);

        $this->assertTrue($entity->is_kept);
    }

    /** @test */
    public function it_can_get_unkept_older_than_hours()
    {
        factory(EntityWithKeptFlag::class, 3)->create([
            'is_kept' => true,
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
