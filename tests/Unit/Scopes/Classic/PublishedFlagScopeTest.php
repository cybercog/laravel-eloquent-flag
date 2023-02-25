<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <anton@komarev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Tests\Laravel\Flag\Unit\Scopes\Classic;

use Cog\Tests\Laravel\Flag\Stubs\Models\Classic\EntityWithPublishedFlag;
use Cog\Tests\Laravel\Flag\Stubs\Models\Classic\EntityWithPublishedFlagApplied;
use Cog\Tests\Laravel\Flag\Stubs\Models\Classic\EntityWithPublishedFlagUnapplied;
use Cog\Tests\Laravel\Flag\TestCase;

final class PublishedFlagScopeTest extends TestCase
{
    /** @test */
    public function it_get_without_global_scope_default(): void
    {
        EntityWithPublishedFlag::factory()->count(3)->create([
            'is_published' => true,
        ]);
        EntityWithPublishedFlag::factory()->count(2)->create([
            'is_published' => false,
        ]);

        $entities = EntityWithPublishedFlag::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_without_not_published(): void
    {
        EntityWithPublishedFlag::factory()->count(3)->create([
            'is_published' => true,
        ]);
        EntityWithPublishedFlag::factory()->count(2)->create([
            'is_published' => false,
        ]);

        $entities = EntityWithPublishedFlag::withoutNotPublished()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_not_published(): void
    {
        EntityWithPublishedFlag::factory()->count(3)->create([
            'is_published' => true,
        ]);
        EntityWithPublishedFlag::factory()->count(2)->create([
            'is_published' => false,
        ]);

        $entities = EntityWithPublishedFlag::withNotPublished()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_not_published(): void
    {
        EntityWithPublishedFlag::factory()->count(3)->create([
            'is_published' => true,
        ]);
        EntityWithPublishedFlag::factory()->count(2)->create([
            'is_published' => false,
        ]);

        $entities = EntityWithPublishedFlag::onlyNotPublished()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_publish_model(): void
    {
        $model = EntityWithPublishedFlag::factory()->create([
            'is_published' => false,
        ]);

        EntityWithPublishedFlag::where('id', $model->id)->publish();

        $model = EntityWithPublishedFlag::where('id', $model->id)->first();

        $this->assertTrue($model->is_published);
    }

    /** @test */
    public function it_can_undo_publish_model(): void
    {
        $model = EntityWithPublishedFlag::factory()->create([
            'is_published' => true,
        ]);

        EntityWithPublishedFlag::where('id', $model->id)->undoPublish();

        $model = EntityWithPublishedFlag::withNotPublished()->where('id', $model->id)->first();

        $this->assertFalse($model->is_published);
    }

    /** @test */
    public function it_can_skip_apply(): void
    {
        EntityWithPublishedFlag::factory()->count(3)->create([
            'is_published' => true,
        ]);
        EntityWithPublishedFlag::factory()->count(2)->create([
            'is_published' => false,
        ]);

        $entities = EntityWithPublishedFlagUnapplied::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_auto_apply(): void
    {
        EntityWithPublishedFlag::factory()->count(3)->create([
            'is_published' => true,
        ]);
        EntityWithPublishedFlag::factory()->count(2)->create([
            'is_published' => false,
        ]);

        $entities = EntityWithPublishedFlagApplied::all();

        $this->assertCount(3, $entities);
    }
}
