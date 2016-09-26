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

use Cog\Flag\Tests\Stubs\Models\EntityWithPublishedFlag;
use Cog\Flag\Tests\TestCase;

/**
 * Class HasPublishedFlagTest.
 *
 * @package Cog\Merchant\Tests\Unit
 */
class HasPublishedFlagTest extends TestCase
{
    /** @test */
    public function it_can_get_only_active()
    {
        factory(EntityWithPublishedFlag::class, 3)->create([
            'is_published' => true,
        ]);
        factory(EntityWithPublishedFlag::class, 2)->create([
            'is_published' => false,
        ]);

        $entities = EntityWithPublishedFlag::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_inactive()
    {
        factory(EntityWithPublishedFlag::class, 3)->create([
            'is_published' => true,
        ]);
        factory(EntityWithPublishedFlag::class, 2)->create([
            'is_published' => false,
        ]);

        $entities = EntityWithPublishedFlag::withoutUnpublished()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_only_inactive()
    {
        factory(EntityWithPublishedFlag::class, 3)->create([
            'is_published' => true,
        ]);
        factory(EntityWithPublishedFlag::class, 2)->create([
            'is_published' => false,
        ]);

        $entities = EntityWithPublishedFlag::onlyUnpublished()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_activate_model()
    {
        $method = factory(EntityWithPublishedFlag::class)->create([
            'is_published' => false,
        ]);

        EntityWithPublishedFlag::where('id', $method->id)->publish();

        $method = EntityWithPublishedFlag::where('id', $method->id)->first();

        $this->assertTrue($method->is_published);
    }

    /** @test */
    public function it_can_deactivate_model()
    {
        $method = factory(EntityWithPublishedFlag::class)->create([
            'is_published' => true,
        ]);

        EntityWithPublishedFlag::where('id', $method->id)->unpublish();

        $method = EntityWithPublishedFlag::withUnpublished()->where('id', $method->id)->first();

        $this->assertFalse($method->is_published);
    }
}
