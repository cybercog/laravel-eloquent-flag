<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Tests\Flag\Unit\Scopes\Classic;

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithVerifiedFlag;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithVerifiedFlagUnapplied;
use Cog\Tests\Flag\TestCase;

final class VerifiedFlagScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_verified(): void
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
    public function it_can_get_without_not_verified(): void
    {
        factory(EntityWithVerifiedFlag::class, 3)->create([
            'is_verified' => true,
        ]);
        factory(EntityWithVerifiedFlag::class, 2)->create([
            'is_verified' => false,
        ]);

        $entities = EntityWithVerifiedFlag::withoutNotVerified()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_not_verified(): void
    {
        factory(EntityWithVerifiedFlag::class, 3)->create([
            'is_verified' => true,
        ]);
        factory(EntityWithVerifiedFlag::class, 2)->create([
            'is_verified' => false,
        ]);

        $entities = EntityWithVerifiedFlag::withNotVerified()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_not_verified(): void
    {
        factory(EntityWithVerifiedFlag::class, 3)->create([
            'is_verified' => true,
        ]);
        factory(EntityWithVerifiedFlag::class, 2)->create([
            'is_verified' => false,
        ]);

        $entities = EntityWithVerifiedFlag::onlyNotVerified()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_verify_model(): void
    {
        $model = factory(EntityWithVerifiedFlag::class)->create([
            'is_verified' => false,
        ]);

        EntityWithVerifiedFlag::where('id', $model->id)->verify();

        $model = EntityWithVerifiedFlag::where('id', $model->id)->first();

        $this->assertTrue($model->is_verified);
    }

    /** @test */
    public function it_can_undo_verify_model(): void
    {
        $model = factory(EntityWithVerifiedFlag::class)->create([
            'is_verified' => true,
        ]);

        EntityWithVerifiedFlag::where('id', $model->id)->undoVerify();

        $model = EntityWithVerifiedFlag::withNotVerified()->where('id', $model->id)->first();

        $this->assertFalse($model->is_verified);
    }

    /** @test */
    public function it_can_skip_apply(): void
    {
        factory(EntityWithVerifiedFlag::class, 3)->create([
            'is_verified' => true,
        ]);
        factory(EntityWithVerifiedFlag::class, 2)->create([
            'is_verified' => false,
        ]);

        $entities = EntityWithVerifiedFlagUnapplied::all();

        $this->assertCount(5, $entities);
    }
}
