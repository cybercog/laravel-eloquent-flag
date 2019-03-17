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

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithVerifiedAt;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithVerifiedAtApplied;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithVerifiedAtUnapplied;
use Cog\Tests\Flag\TestCase;
use Illuminate\Support\Facades\Date;

final class VerifiedAtScopeTest extends TestCase
{
    /** @test */
    public function it_get_without_global_scope_default(): void
    {
        factory(EntityWithVerifiedAt::class, 3)->create([
            'verified_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithVerifiedAt::class, 2)->create([
            'verified_at' => null,
        ]);

        $entities = EntityWithVerifiedAt::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_without_not_verified(): void
    {
        factory(EntityWithVerifiedAt::class, 3)->create([
            'verified_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithVerifiedAt::class, 2)->create([
            'verified_at' => null,
        ]);

        $entities = EntityWithVerifiedAt::withoutNotVerified()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_not_verified(): void
    {
        factory(EntityWithVerifiedAt::class, 3)->create([
            'verified_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithVerifiedAt::class, 2)->create([
            'verified_at' => null,
        ]);

        $entities = EntityWithVerifiedAt::withNotVerified()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_not_verified(): void
    {
        factory(EntityWithVerifiedAt::class, 3)->create([
            'verified_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithVerifiedAt::class, 2)->create([
            'verified_at' => null,
        ]);

        $entities = EntityWithVerifiedAt::onlyNotVerified()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_verify_model(): void
    {
        $model = factory(EntityWithVerifiedAt::class)->create([
            'verified_at' => null,
        ]);

        EntityWithVerifiedAt::where('id', $model->id)->verify();

        $model = EntityWithVerifiedAt::where('id', $model->id)->first();

        $this->assertNotNull($model->verified_at);
    }

    /** @test */
    public function it_can_undo_verify_model(): void
    {
        $model = factory(EntityWithVerifiedAt::class)->create([
            'verified_at' => Date::now()->subDay(),
        ]);

        EntityWithVerifiedAt::where('id', $model->id)->undoVerify();

        $model = EntityWithVerifiedAt::withNotVerified()->where('id', $model->id)->first();

        $this->assertNull($model->verified_at);
    }

    /** @test */
    public function it_can_skip_apply(): void
    {
        factory(EntityWithVerifiedAt::class, 3)->create([
            'verified_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithVerifiedAt::class, 2)->create([
            'verified_at' => null,
        ]);

        $entities = EntityWithVerifiedAtUnapplied::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_auto_apply(): void
    {
        factory(EntityWithVerifiedAt::class, 3)->create([
            'verified_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithVerifiedAt::class, 2)->create([
            'verified_at' => null,
        ]);

        $entities = EntityWithVerifiedAtApplied::all();

        $this->assertCount(3, $entities);
    }
}
