<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) CyberCog <support@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Tests\Unit\Scopes\Inverse;

use Cog\Flag\Tests\Stubs\Models\Inverse\EntityWithExpiredFlag;
use Cog\Flag\Tests\TestCase;

/**
 * Class ExpiredFlagScopeTest.
 *
 * @package Cog\Flag\Tests\Unit\Scopes\Inverse
 */
class ExpiredFlagScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_not_expired()
    {
        factory(EntityWithExpiredFlag::class, 2)->create([
            'is_expired' => true,
        ]);
        factory(EntityWithExpiredFlag::class, 3)->create([
            'is_expired' => false,
        ]);

        $entities = EntityWithExpiredFlag::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_expired()
    {
        factory(EntityWithExpiredFlag::class, 2)->create([
            'is_expired' => true,
        ]);
        factory(EntityWithExpiredFlag::class, 3)->create([
            'is_expired' => false,
        ]);

        $entities = EntityWithExpiredFlag::withoutExpired()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_expired()
    {
        factory(EntityWithExpiredFlag::class, 2)->create([
            'is_expired' => true,
        ]);
        factory(EntityWithExpiredFlag::class, 3)->create([
            'is_expired' => false,
        ]);

        $entities = EntityWithExpiredFlag::withExpired()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_expired()
    {
        factory(EntityWithExpiredFlag::class, 2)->create([
            'is_expired' => true,
        ]);
        factory(EntityWithExpiredFlag::class, 3)->create([
            'is_expired' => false,
        ]);

        $entities = EntityWithExpiredFlag::onlyExpired()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_unexpire_model()
    {
        $model = factory(EntityWithExpiredFlag::class)->create([
            'is_expired' => true,
        ]);

        EntityWithExpiredFlag::where('id', $model->id)->unexpire();

        $model = EntityWithExpiredFlag::where('id', $model->id)->first();

        $this->assertFalse($model->is_expired);
    }

    /** @test */
    public function it_can_expire_model()
    {
        $model = factory(EntityWithExpiredFlag::class)->create([
            'is_expired' => false,
        ]);

        EntityWithExpiredFlag::where('id', $model->id)->expire();

        $model = EntityWithExpiredFlag::withExpired()->where('id', $model->id)->first();

        $this->assertTrue($model->is_expired);
    }
}
