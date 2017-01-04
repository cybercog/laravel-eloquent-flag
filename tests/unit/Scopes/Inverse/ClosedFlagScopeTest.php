<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) CyberCog <support@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Tests\Unit\Scopes\Inverse;

use Cog\Flag\Tests\Stubs\Models\Inverse\EntityWithClosedFlag;
use Cog\Flag\Tests\TestCase;

/**
 * Class ClosedFlagScopeTest.
 *
 * @package Cog\Flag\Tests\Unit\Scopes\Inverse
 */
class ClosedFlagScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_not_closed()
    {
        factory(EntityWithClosedFlag::class, 2)->create([
            'is_closed' => true,
        ]);
        factory(EntityWithClosedFlag::class, 3)->create([
            'is_closed' => false,
        ]);

        $entities = EntityWithClosedFlag::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_closed()
    {
        factory(EntityWithClosedFlag::class, 2)->create([
            'is_closed' => true,
        ]);
        factory(EntityWithClosedFlag::class, 3)->create([
            'is_closed' => false,
        ]);

        $entities = EntityWithClosedFlag::withoutClosed()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_closed()
    {
        factory(EntityWithClosedFlag::class, 2)->create([
            'is_closed' => true,
        ]);
        factory(EntityWithClosedFlag::class, 3)->create([
            'is_closed' => false,
        ]);

        $entities = EntityWithClosedFlag::withClosed()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_closed()
    {
        factory(EntityWithClosedFlag::class, 2)->create([
            'is_closed' => true,
        ]);
        factory(EntityWithClosedFlag::class, 3)->create([
            'is_closed' => false,
        ]);

        $entities = EntityWithClosedFlag::onlyClosed()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_open_model()
    {
        $model = factory(EntityWithClosedFlag::class)->create([
            'is_closed' => true,
        ]);

        EntityWithClosedFlag::where('id', $model->id)->open();

        $model = EntityWithClosedFlag::where('id', $model->id)->first();

        $this->assertFalse($model->is_closed);
    }

    /** @test */
    public function it_can_close_model()
    {
        $model = factory(EntityWithClosedFlag::class)->create([
            'is_closed' => false,
        ]);

        EntityWithClosedFlag::where('id', $model->id)->close();

        $model = EntityWithClosedFlag::withClosed()->where('id', $model->id)->first();

        $this->assertTrue($model->is_closed);
    }
}
