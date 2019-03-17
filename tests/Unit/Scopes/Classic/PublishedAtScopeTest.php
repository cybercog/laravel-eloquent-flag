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

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithPublishedAt;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithPublishedAtApplied;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithPublishedAtUnapplied;
use Cog\Tests\Flag\TestCase;
use Illuminate\Support\Facades\Date;

final class PublishedAtScopeTest extends TestCase
{
    /** @test */
    public function it_get_without_global_scope_default(): void
    {
        factory(EntityWithPublishedAt::class, 3)->create([
            'published_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithPublishedAt::class, 2)->create([
            'published_at' => null,
        ]);

        $entities = EntityWithPublishedAt::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_without_not_published(): void
    {
        factory(EntityWithPublishedAt::class, 3)->create([
            'published_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithPublishedAt::class, 2)->create([
            'published_at' => null,
        ]);

        $entities = EntityWithPublishedAt::withoutNotPublished()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_not_published(): void
    {
        factory(EntityWithPublishedAt::class, 3)->create([
            'published_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithPublishedAt::class, 2)->create([
            'published_at' => null,
        ]);

        $entities = EntityWithPublishedAt::withNotPublished()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_not_published(): void
    {
        factory(EntityWithPublishedAt::class, 3)->create([
            'published_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithPublishedAt::class, 2)->create([
            'published_at' => null,
        ]);

        $entities = EntityWithPublishedAt::onlyNotPublished()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_publish_model(): void
    {
        $model = factory(EntityWithPublishedAt::class)->create([
            'published_at' => null,
        ]);

        EntityWithPublishedAt::where('id', $model->id)->publish();

        $model = EntityWithPublishedAt::where('id', $model->id)->first();

        $this->assertNotNull($model->published_at);
    }

    /** @test */
    public function it_can_undo_publish_model(): void
    {
        $model = factory(EntityWithPublishedAt::class)->create([
            'published_at' => Date::now()->subDay(),
        ]);

        EntityWithPublishedAt::where('id', $model->id)->undoPublish();

        $model = EntityWithPublishedAt::withNotPublished()->where('id', $model->id)->first();

        $this->assertNull($model->published_at);
    }

    /** @test */
    public function it_can_skip_apply(): void
    {
        factory(EntityWithPublishedAt::class, 3)->create([
            'published_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithPublishedAt::class, 2)->create([
            'published_at' => null,
        ]);

        $entities = EntityWithPublishedAtUnapplied::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_auto_apply(): void
    {
        factory(EntityWithPublishedAt::class, 3)->create([
            'published_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithPublishedAt::class, 2)->create([
            'published_at' => null,
        ]);

        $entities = EntityWithPublishedAtApplied::all();

        $this->assertCount(3, $entities);
    }
}
