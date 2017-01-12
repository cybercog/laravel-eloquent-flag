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

use Cog\Flag\Tests\Stubs\Models\Classic\EntityWithVerifiedFlag;
use Cog\Flag\Tests\TestCase;

/**
 * Class VerifiedFlagScopeTest.
 *
 * @package Cog\Flag\Tests\Unit\Scopes\Classic
 */
class VerifiedFlagScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_verified()
    {
        factory(EntityWithVerifiedFlag::class, 3)->create([
            'is_verified' => true,
        ]);
        factory(EntityWithVerifiedFlag::class, 2)->create([
            'is_verified' => false,
        ]);

        $entities = EntityWithVerifiedFlag::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_unverified()
    {
        factory(EntityWithVerifiedFlag::class, 3)->create([
            'is_verified' => true,
        ]);
        factory(EntityWithVerifiedFlag::class, 2)->create([
            'is_verified' => false,
        ]);

        $entities = EntityWithVerifiedFlag::withoutUnverified()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_unverified()
    {
        factory(EntityWithVerifiedFlag::class, 3)->create([
            'is_verified' => true,
        ]);
        factory(EntityWithVerifiedFlag::class, 2)->create([
            'is_verified' => false,
        ]);

        $entities = EntityWithVerifiedFlag::withUnverified()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_unverified()
    {
        factory(EntityWithVerifiedFlag::class, 3)->create([
            'is_verified' => true,
        ]);
        factory(EntityWithVerifiedFlag::class, 2)->create([
            'is_verified' => false,
        ]);

        $entities = EntityWithVerifiedFlag::onlyUnverified()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_verify_model()
    {
        $model = factory(EntityWithVerifiedFlag::class)->create([
            'is_verified' => false,
        ]);

        EntityWithVerifiedFlag::where('id', $model->id)->verify();

        $model = EntityWithVerifiedFlag::where('id', $model->id)->first();

        $this->assertTrue($model->is_verified);
    }

    /** @test */
    public function it_can_unverify_model()
    {
        $model = factory(EntityWithVerifiedFlag::class)->create([
            'is_verified' => true,
        ]);

        EntityWithVerifiedFlag::where('id', $model->id)->unverify();

        $model = EntityWithVerifiedFlag::withUnverified()->where('id', $model->id)->first();

        $this->assertFalse($model->is_verified);
    }
}
