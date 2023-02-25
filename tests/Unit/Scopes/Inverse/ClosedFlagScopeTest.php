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

use Cog\Tests\Laravel\Flag\Stubs\Models\Inverse\EntityWithClosedFlag;
use Cog\Tests\Laravel\Flag\Stubs\Models\Inverse\EntityWithClosedFlagApplied;
use Cog\Tests\Laravel\Flag\Stubs\Models\Inverse\EntityWithClosedFlagUnapplied;
use Cog\Tests\Laravel\Flag\TestCase;

final class ClosedFlagScopeTest extends TestCase
{
    /** @test */
    public function it_get_without_global_scope_default(): void
    {
        EntityWithClosedFlag::factory()->count(3)->create([
            'is_closed' => true,
        ]);
        EntityWithClosedFlag::factory()->count(2)->create([
            'is_closed' => false,
        ]);

        $entities = EntityWithClosedFlag::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_without_closed(): void
    {
        EntityWithClosedFlag::factory()->count(3)->create([
            'is_closed' => true,
        ]);
        EntityWithClosedFlag::factory()->count(2)->create([
            'is_closed' => false,
        ]);

        $entities = EntityWithClosedFlag::withoutClosed()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_get_with_closed(): void
    {
        EntityWithClosedFlag::factory()->count(3)->create([
            'is_closed' => true,
        ]);
        EntityWithClosedFlag::factory()->count(2)->create([
            'is_closed' => false,
        ]);

        $entities = EntityWithClosedFlag::withClosed()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_closed(): void
    {
        EntityWithClosedFlag::factory()->count(3)->create([
            'is_closed' => true,
        ]);
        EntityWithClosedFlag::factory()->count(2)->create([
            'is_closed' => false,
        ]);

        $entities = EntityWithClosedFlag::onlyClosed()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_undo_close_model(): void
    {
        $model = EntityWithClosedFlag::factory()->create([
            'is_closed' => true,
        ]);

        EntityWithClosedFlag::where('id', $model->id)->undoClose();

        $model = EntityWithClosedFlag::where('id', $model->id)->first();

        $this->assertFalse($model->is_closed);
    }

    /** @test */
    public function it_can_close_model(): void
    {
        $model = EntityWithClosedFlag::factory()->create([
            'is_closed' => false,
        ]);

        EntityWithClosedFlag::where('id', $model->id)->close();

        $model = EntityWithClosedFlag::withClosed()->where('id', $model->id)->first();

        $this->assertTrue($model->is_closed);
    }

    /** @test */
    public function it_can_skip_auto_apply(): void
    {
        EntityWithClosedFlag::factory()->count(3)->create([
            'is_closed' => true,
        ]);
        EntityWithClosedFlag::factory()->count(2)->create([
            'is_closed' => false,
        ]);

        $entities = EntityWithClosedFlagUnapplied::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_auto_apply(): void
    {
        EntityWithClosedFlag::factory()->count(3)->create([
            'is_closed' => true,
        ]);
        EntityWithClosedFlag::factory()->count(2)->create([
            'is_closed' => false,
        ]);

        $entities = EntityWithClosedFlagApplied::all();

        $this->assertCount(2, $entities);
    }
}
