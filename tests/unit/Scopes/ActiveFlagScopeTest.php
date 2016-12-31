<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) CyberCog <support@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Tests\Unit\Scopes;

use Cog\Flag\Tests\TestCase;
use Cog\Flag\Tests\Stubs\Models\EntityWithActiveFlag;

/**
 * Class ActiveFlagScopeTest.
 *
 * @package Cog\Flag\Tests\Unit\Scopes
 */
class ActiveFlagScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_active()
    {
        factory(EntityWithActiveFlag::class, 3)->create([
            'is_active' => true,
        ]);
        factory(EntityWithActiveFlag::class, 2)->create([
            'is_active' => false,
        ]);

        $entities = EntityWithActiveFlag::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_inactive()
    {
        factory(EntityWithActiveFlag::class, 3)->create([
            'is_active' => true,
        ]);
        factory(EntityWithActiveFlag::class, 2)->create([
            'is_active' => false,
        ]);

        $entities = EntityWithActiveFlag::withoutInactive()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_inactive()
    {
        factory(EntityWithActiveFlag::class, 3)->create([
            'is_active' => true,
        ]);
        factory(EntityWithActiveFlag::class, 2)->create([
            'is_active' => false,
        ]);

        $entities = EntityWithActiveFlag::withInactive()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_inactive()
    {
        factory(EntityWithActiveFlag::class, 3)->create([
            'is_active' => true,
        ]);
        factory(EntityWithActiveFlag::class, 2)->create([
            'is_active' => false,
        ]);

        $entities = EntityWithActiveFlag::onlyInactive()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_activate_model()
    {
        $model = factory(EntityWithActiveFlag::class)->create([
            'is_active' => false,
        ]);

        EntityWithActiveFlag::where('id', $model->id)->activate();

        $model = EntityWithActiveFlag::where('id', $model->id)->first();

        $this->assertTrue($model->is_active);
    }

    /** @test */
    public function it_can_deactivate_model()
    {
        $model = factory(EntityWithActiveFlag::class)->create([
            'is_active' => true,
        ]);

        EntityWithActiveFlag::where('id', $model->id)->deactivate();

        $model = EntityWithActiveFlag::withInactive()->where('id', $model->id)->first();

        $this->assertFalse($model->is_active);
    }
}
