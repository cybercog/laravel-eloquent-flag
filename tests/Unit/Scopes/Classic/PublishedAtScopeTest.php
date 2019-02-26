<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Tests\Flag\Unit\Scopes\Classic;

use Carbon\Carbon;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithPublishedAt;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithPublishedAtUnapplied;
use Cog\Tests\Flag\TestCase;

class PublishedAtScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_published()
    {
        factory(EntityWithPublishedAt::class, 3)->create([
            'published_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithPublishedAt::class, 2)->create([
            'published_at' => null,
        ]);

        $entities = EntityWithPublishedAt::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_unpublished()
    {
        factory(EntityWithPublishedAt::class, 3)->create([
            'published_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithPublishedAt::class, 2)->create([
            'published_at' => null,
        ]);

        $entities = EntityWithPublishedAt::withoutUnpublished()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_unpublished()
    {
        factory(EntityWithPublishedAt::class, 3)->create([
            'published_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithPublishedAt::class, 2)->create([
            'published_at' => null,
        ]);

        $entities = EntityWithPublishedAt::withUnpublished()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_unpublished()
    {
        factory(EntityWithPublishedAt::class, 3)->create([
            'published_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithPublishedAt::class, 2)->create([
            'published_at' => null,
        ]);

        $entities = EntityWithPublishedAt::onlyUnpublished()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_publish_model()
    {
        $model = factory(EntityWithPublishedAt::class)->create([
            'published_at' => null,
        ]);

        EntityWithPublishedAt::where('id', $model->id)->publish();

        $model = EntityWithPublishedAt::where('id', $model->id)->first();

        $this->assertNotNull($model->published_at);
    }

    /** @test */
    public function it_can_unpublish_model()
    {
        $model = factory(EntityWithPublishedAt::class)->create([
            'published_at' => Carbon::now()->subDay(),
        ]);

        EntityWithPublishedAt::where('id', $model->id)->unpublish();

        $model = EntityWithPublishedAt::withUnpublished()->where('id', $model->id)->first();

        $this->assertNull($model->published_at);
    }

    /** @test */
    public function it_can_skip_apply()
    {
        factory(EntityWithPublishedAt::class, 3)->create([
            'published_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithPublishedAt::class, 2)->create([
            'published_at' => null,
        ]);

        $entities = EntityWithPublishedAtUnapplied::all();

        $this->assertCount(5, $entities);
    }
}
