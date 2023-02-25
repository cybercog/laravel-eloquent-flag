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

use Cog\Tests\Laravel\Flag\Stubs\Models\Inverse\EntityWithExpiredFlag;
use Cog\Tests\Laravel\Flag\Stubs\Models\Inverse\EntityWithExpiredFlagApplied;
use Cog\Tests\Laravel\Flag\Stubs\Models\Inverse\EntityWithExpiredFlagUnapplied;
use Cog\Tests\Laravel\Flag\TestCase;

final class ExpiredFlagScopeTest extends TestCase
{
    /** @test */
    public function it_get_without_global_scope_default(): void
    {
        EntityWithExpiredFlag::factory()->count(3)->create([
            'is_expired' => true,
        ]);
        EntityWithExpiredFlag::factory()->count(2)->create([
            'is_expired' => false,
        ]);

        $entities = EntityWithExpiredFlag::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_without_expired(): void
    {
        EntityWithExpiredFlag::factory()->count(3)->create([
            'is_expired' => true,
        ]);
        EntityWithExpiredFlag::factory()->count(2)->create([
            'is_expired' => false,
        ]);

        $entities = EntityWithExpiredFlag::withoutExpired()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_get_with_expired(): void
    {
        EntityWithExpiredFlag::factory()->count(3)->create([
            'is_expired' => true,
        ]);
        EntityWithExpiredFlag::factory()->count(2)->create([
            'is_expired' => false,
        ]);

        $entities = EntityWithExpiredFlag::withExpired()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_expired(): void
    {
        EntityWithExpiredFlag::factory()->count(3)->create([
            'is_expired' => true,
        ]);
        EntityWithExpiredFlag::factory()->count(2)->create([
            'is_expired' => false,
        ]);

        $entities = EntityWithExpiredFlag::onlyExpired()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_undo_expire_model(): void
    {
        $model = EntityWithExpiredFlag::factory()->create([
            'is_expired' => true,
        ]);

        EntityWithExpiredFlag::where('id', $model->id)->undoExpire();

        $model = EntityWithExpiredFlag::where('id', $model->id)->first();

        $this->assertFalse($model->is_expired);
    }

    /** @test */
    public function it_can_expire_model(): void
    {
        $model = EntityWithExpiredFlag::factory()->create([
            'is_expired' => false,
        ]);

        EntityWithExpiredFlag::where('id', $model->id)->expire();

        $model = EntityWithExpiredFlag::withExpired()->where('id', $model->id)->first();

        $this->assertTrue($model->is_expired);
    }

    /** @test */
    public function it_can_skip_apply(): void
    {
        EntityWithExpiredFlag::factory()->count(3)->create([
            'is_expired' => true,
        ]);
        EntityWithExpiredFlag::factory()->count(2)->create([
            'is_expired' => false,
        ]);

        $entities = EntityWithExpiredFlagUnapplied::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_auto_apply(): void
    {
        EntityWithExpiredFlag::factory()->count(3)->create([
            'is_expired' => true,
        ]);
        EntityWithExpiredFlag::factory()->count(2)->create([
            'is_expired' => false,
        ]);

        $entities = EntityWithExpiredFlagApplied::all();

        $this->assertCount(2, $entities);
    }
}
