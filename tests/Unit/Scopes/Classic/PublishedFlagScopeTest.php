<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Tests\Flag\Unit\Scopes\Classic;

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithPublishedFlag;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithPublishedFlagUnapplied;
use Cog\Tests\Flag\TestCase;

class PublishedFlagScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_published(): void
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
    public function it_can_get_without_unpublished(): void
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
    public function it_can_get_with_unpublished(): void
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
    public function it_can_get_only_unpublished(): void
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
    public function it_can_publish_model(): void
    {
        $model = factory(EntityWithPublishedFlag::class)->create([
            'is_published' => false,
        ]);

        EntityWithPublishedFlag::where('id', $model->id)->publish();

        $model = EntityWithPublishedFlag::where('id', $model->id)->first();

        $this->assertTrue($model->is_published);
    }

    /** @test */
    public function it_can_unpublish_model(): void
    {
        $model = factory(EntityWithPublishedFlag::class)->create([
            'is_published' => true,
        ]);

        EntityWithPublishedFlag::where('id', $model->id)->unpublish();

        $model = EntityWithPublishedFlag::withUnpublished()->where('id', $model->id)->first();

        $this->assertFalse($model->is_published);
    }

    /** @test */
    public function it_can_skip_apply(): void
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
