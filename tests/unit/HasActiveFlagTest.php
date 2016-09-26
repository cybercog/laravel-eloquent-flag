<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) CyberCog <support@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Tests\Unit;

use Cog\Flag\Tests\Stubs\Models\Entity;
use Cog\Flag\Tests\TestCase;

/**
 * Class HasActiveFlagTest.
 *
 * @package Cog\Merchant\Tests\Unit
 */
class HasActiveFlagTest extends TestCase
{
    /** @test */
    public function it_can_get_only_active()
    {
        factory(Entity::class, 3)->create([
            'is_active' => true,
        ]);
        factory(Entity::class, 2)->create([
            'is_active' => false,
        ]);

        $entities = Entity::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_inactive()
    {
        factory(Entity::class, 3)->create([
            'is_active' => true,
        ]);
        factory(Entity::class, 2)->create([
            'is_active' => false,
        ]);

        $entities = Entity::withoutInactive()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_only_inactive()
    {
        factory(Entity::class, 3)->create([
            'is_active' => true,
        ]);
        factory(Entity::class, 2)->create([
            'is_active' => false,
        ]);

        $entities = Entity::onlyInactive()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_activate_model()
    {
        $method = factory(Entity::class)->create([
            'is_active' => false,
        ]);

        Entity::where('id', $method->id)->activate();

        $method = Entity::where('id', $method->id)->first();

        $this->assertTrue($method->is_active);
    }

    /** @test */
    public function it_can_deactivate_model()
    {
        $method = factory(Entity::class)->create([
            'is_active' => true,
        ]);

        Entity::where('id', $method->id)->deactivate();

        $method = Entity::withInactive()->where('id', $method->id)->first();

        $this->assertFalse($method->is_active);
    }
}
