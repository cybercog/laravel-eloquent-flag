<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Tests\Unit\Scopes\Classic;

use Cog\Flag\Tests\Stubs\Models\Classic\EntityWithPublishedFlag;
use Cog\Flag\Tests\Stubs\Models\Classic\EntityWithPublishedFlagUnapplied;
use Cog\Flag\Tests\TestCase;

/**
 * Class PublishedFlagScopeTest.
 *
 * @package Cog\Flag\Tests\Unit\Scopes\Classic
 */
class PublishedFlagScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_published()
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
    public function it_can_get_without_unpublished()
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
    public function it_can_get_with_unpublished()
    {
        factory(EntityWithPublishedFlag::class, 3)->create([
            'is_published' => true,
        ]);
        factory(EntityWithPublishedFlag::class, 2)->create([
            'is_published' => false,
        ]);

        $entities = EntityWithPublishedFlag::withUnpublished()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_unpublished()
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
    public function it_can_publish_model()
    {
        $model = factory(EntityWithPublishedFlag::class)->create([
            'is_published' => false,
        ]);

        EntityWithPublishedFlag::where('id', $model->id)->publish();

        $model = EntityWithPublishedFlag::where('id', $model->id)->first();

        $this->assertTrue($model->is_published);
    }

    /** @test */
    public function it_can_unpublish_model()
    {
        $model = factory(EntityWithPublishedFlag::class)->create([
            'is_published' => true,
        ]);

        EntityWithPublishedFlag::where('id', $model->id)->unpublish();

        $model = EntityWithPublishedFlag::withUnpublished()->where('id', $model->id)->first();

        $this->assertFalse($model->is_published);
    }

    /** @test */
    public function it_can_skip_apply()
    {
        factory(EntityWithPublishedFlag::class, 3)->create([
            'is_published' => true,
        ]);
        factory(EntityWithPublishedFlag::class, 2)->create([
            'is_published' => false,
        ]);

        $entities = EntityWithPublishedFlagUnapplied::all();

        $this->assertCount(5, $entities);
    }
}
