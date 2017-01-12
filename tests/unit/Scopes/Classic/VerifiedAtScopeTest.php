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

use Carbon\Carbon;
use Cog\Flag\Tests\Stubs\Models\Classic\EntityWithVerifiedAt;
use Cog\Flag\Tests\TestCase;

/**
 * Class VerifiedAtScopeTest.
 *
 * @package Cog\Flag\Tests\Unit\Scopes\Classic
 */
class VerifiedAtScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_verified()
    {
        factory(EntityWithVerifiedAt::class, 3)->create([
            'verified_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithVerifiedAt::class, 2)->create([
            'verified_at' => null,
        ]);

        $entities = EntityWithVerifiedAt::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_unverified()
    {
        factory(EntityWithVerifiedAt::class, 3)->create([
            'verified_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithVerifiedAt::class, 2)->create([
            'verified_at' => null,
        ]);

        $entities = EntityWithVerifiedAt::withoutUnverified()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_unverified()
    {
        factory(EntityWithVerifiedAt::class, 3)->create([
            'verified_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithVerifiedAt::class, 2)->create([
            'verified_at' => null,
        ]);

        $entities = EntityWithVerifiedAt::withUnverified()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_unverified()
    {
        factory(EntityWithVerifiedAt::class, 3)->create([
            'verified_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithVerifiedAt::class, 2)->create([
            'verified_at' => null,
        ]);

        $entities = EntityWithVerifiedAt::onlyUnverified()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_verify_model()
    {
        $model = factory(EntityWithVerifiedAt::class)->create([
            'verified_at' => null,
        ]);

        EntityWithVerifiedAt::where('id', $model->id)->verify();

        $model = EntityWithVerifiedAt::where('id', $model->id)->first();

        $this->assertNotNull($model->verified_at);
    }

    /** @test */
    public function it_can_unverify_model()
    {
        $model = factory(EntityWithVerifiedAt::class)->create([
            'verified_at' => Carbon::now()->subDay(),
        ]);

        EntityWithVerifiedAt::where('id', $model->id)->unverify();

        $model = EntityWithVerifiedAt::withUnverified()->where('id', $model->id)->first();

        $this->assertNull($model->verified_at);
    }
}
