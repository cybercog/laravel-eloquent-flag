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

use Cog\Tests\Laravel\Flag\Stubs\Models\Inverse\EntityWithExpiredAt;
use Cog\Tests\Laravel\Flag\Stubs\Models\Inverse\EntityWithExpiredAtApplied;
use Cog\Tests\Laravel\Flag\Stubs\Models\Inverse\EntityWithExpiredAtUnapplied;
use Cog\Tests\Laravel\Flag\TestCase;
use Illuminate\Support\Facades\Date;

final class ExpiredAtScopeTest extends TestCase
{
    /** @test */
    public function it_get_without_global_scope_default(): void
    {
        factory(EntityWithExpiredAt::class, 3)->create([
            'expired_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithExpiredAt::class, 2)->create([
            'expired_at' => null,
        ]);

        $entities = EntityWithExpiredAt::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_without_expired(): void
    {
        factory(EntityWithExpiredAt::class, 3)->create([
            'expired_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithExpiredAt::class, 2)->create([
            'expired_at' => null,
        ]);

        $entities = EntityWithExpiredAt::withoutExpired()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_get_with_expired(): void
    {
        factory(EntityWithExpiredAt::class, 3)->create([
            'expired_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithExpiredAt::class, 2)->create([
            'expired_at' => null,
        ]);

        $entities = EntityWithExpiredAt::withExpired()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_expired(): void
    {
        factory(EntityWithExpiredAt::class, 3)->create([
            'expired_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithExpiredAt::class, 2)->create([
            'expired_at' => null,
        ]);

        $entities = EntityWithExpiredAt::onlyExpired()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_undo_expire_model(): void
    {
        $model = factory(EntityWithExpiredAt::class)->create([
            'expired_at' => Date::now()->subDay(),
        ]);

        EntityWithExpiredAt::where('id', $model->id)->undoExpire();

        $model = EntityWithExpiredAt::where('id', $model->id)->first();

        $this->assertNull($model->expired_at);
    }

    /** @test */
    public function it_can_expire_model(): void
    {
        $model = factory(EntityWithExpiredAt::class)->create([
            'expired_at' => null,
        ]);

        EntityWithExpiredAt::where('id', $model->id)->expire();

        $model = EntityWithExpiredAt::withExpired()->where('id', $model->id)->first();

        $this->assertNotNull($model->expired_at);
    }

    /** @test */
    public function it_can_skip_apply(): void
    {
        factory(EntityWithExpiredAt::class, 3)->create([
            'expired_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithExpiredAt::class, 2)->create([
            'expired_at' => null,
        ]);

        $entities = EntityWithExpiredAtUnapplied::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_auto_apply(): void
    {
        factory(EntityWithExpiredAt::class, 3)->create([
            'expired_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithExpiredAt::class, 2)->create([
            'expired_at' => null,
        ]);

        $entities = EntityWithExpiredAtApplied::all();

        $this->assertCount(2, $entities);
    }
}
