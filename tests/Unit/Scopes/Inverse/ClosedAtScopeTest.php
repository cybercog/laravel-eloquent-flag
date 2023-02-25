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

namespace Cog\Tests\Laravel\Flag\Unit\Scopes\Inverse;

use Cog\Tests\Laravel\Flag\Stubs\Models\Inverse\EntityWithClosedAt;
use Cog\Tests\Laravel\Flag\Stubs\Models\Inverse\EntityWithClosedAtApplied;
use Cog\Tests\Laravel\Flag\Stubs\Models\Inverse\EntityWithClosedAtUnapplied;
use Cog\Tests\Laravel\Flag\TestCase;
use Illuminate\Support\Facades\Date;

final class ClosedAtScopeTest extends TestCase
{
    /** @test */
    public function it_get_without_global_scope_default(): void
    {
        factory(EntityWithClosedAt::class, 3)->create([
            'closed_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithClosedAt::class, 2)->create([
            'closed_at' => null,
        ]);

        $entities = EntityWithClosedAt::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_without_closed(): void
    {
        factory(EntityWithClosedAt::class, 3)->create([
            'closed_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithClosedAt::class, 2)->create([
            'closed_at' => null,
        ]);

        $entities = EntityWithClosedAt::withoutClosed()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_get_with_closed(): void
    {
        factory(EntityWithClosedAt::class, 3)->create([
            'closed_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithClosedAt::class, 2)->create([
            'closed_at' => null,
        ]);

        $entities = EntityWithClosedAt::withClosed()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_closed(): void
    {
        factory(EntityWithClosedAt::class, 3)->create([
            'closed_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithClosedAt::class, 2)->create([
            'closed_at' => null,
        ]);

        $entities = EntityWithClosedAt::onlyClosed()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_undo_close_model(): void
    {
        $model = factory(EntityWithClosedAt::class)->create([
            'closed_at' => Date::now()->subDay(),
        ]);

        EntityWithClosedAt::where('id', $model->id)->undoClose();

        $model = EntityWithClosedAt::where('id', $model->id)->first();

        $this->assertNull($model->closed_at);
    }

    /** @test */
    public function it_can_close_model(): void
    {
        $model = factory(EntityWithClosedAt::class)->create([
            'closed_at' => null,
        ]);

        EntityWithClosedAt::where('id', $model->id)->close();

        $model = EntityWithClosedAt::withClosed()->where('id', $model->id)->first();

        $this->assertNotNull($model->closed_at);
    }

    /** @test */
    public function it_can_skip_auto_apply(): void
    {
        factory(EntityWithClosedAt::class, 3)->create([
            'closed_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithClosedAt::class, 2)->create([
            'closed_at' => null,
        ]);

        $entities = EntityWithClosedAtUnapplied::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_auto_apply(): void
    {
        factory(EntityWithClosedAt::class, 3)->create([
            'closed_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithClosedAt::class, 2)->create([
            'closed_at' => null,
        ]);

        $entities = EntityWithClosedAtApplied::all();

        $this->assertCount(2, $entities);
    }
}
