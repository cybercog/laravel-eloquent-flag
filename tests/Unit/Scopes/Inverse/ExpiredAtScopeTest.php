<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Tests\Flag\Unit\Scopes\Inverse;

use Carbon\Carbon;
use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithExpiredAt;
use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithExpiredAtUnapplied;
use Cog\Tests\Flag\TestCase;

/**
 * Class ExpiredAtScopeTest.
 *
 * @package Cog\Tests\Flag\Unit\Scopes\Inverse
 */
class ExpiredAtScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_not_expired()
    {
        factory(EntityWithExpiredAt::class, 2)->create([
            'expired_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithExpiredAt::class, 3)->create([
            'expired_at' => null,
        ]);

        $entities = EntityWithExpiredAt::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_expired()
    {
        factory(EntityWithExpiredAt::class, 2)->create([
            'expired_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithExpiredAt::class, 3)->create([
            'expired_at' => null,
        ]);

        $entities = EntityWithExpiredAt::withoutExpired()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_expired()
    {
        factory(EntityWithExpiredAt::class, 2)->create([
            'expired_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithExpiredAt::class, 3)->create([
            'expired_at' => null,
        ]);

        $entities = EntityWithExpiredAt::withExpired()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_expired()
    {
        factory(EntityWithExpiredAt::class, 2)->create([
            'expired_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithExpiredAt::class, 3)->create([
            'expired_at' => null,
        ]);

        $entities = EntityWithExpiredAt::onlyExpired()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_unexpire_model()
    {
        $model = factory(EntityWithExpiredAt::class)->create([
            'expired_at' => Carbon::now()->subDay(),
        ]);

        EntityWithExpiredAt::where('id', $model->id)->unexpire();

        $model = EntityWithExpiredAt::where('id', $model->id)->first();

        $this->assertNull($model->expired_at);
    }

    /** @test */
    public function it_can_expire_model()
    {
        $model = factory(EntityWithExpiredAt::class)->create([
            'expired_at' => null,
        ]);

        EntityWithExpiredAt::where('id', $model->id)->expire();

        $model = EntityWithExpiredAt::withExpired()->where('id', $model->id)->first();

        $this->assertNotNull($model->expired_at);
    }

    /** @test */
    public function it_can_skip_apply()
    {
        factory(EntityWithExpiredAt::class, 3)->create([
            'expired_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithExpiredAt::class, 2)->create([
            'expired_at' => null,
        ]);

        $entities = EntityWithExpiredAtUnapplied::all();

        $this->assertCount(5, $entities);
    }
}
