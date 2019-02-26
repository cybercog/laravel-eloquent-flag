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
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithVerifiedAtUnapplied;
use Cog\Tests\Flag\TestCase;
use Illuminate\Support\Carbon;

final class VerifiedAtScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_verified(): void
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
    public function it_can_get_without_unverified(): void
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
    public function it_can_get_with_unverified(): void
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
    public function it_can_get_only_unverified(): void
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
    public function it_can_unverify_model(): void
    {
        $model = factory(EntityWithVerifiedAt::class)->create([
            'verified_at' => Carbon::now()->subDay(),
        ]);

        EntityWithVerifiedAt::where('id', $model->id)->unverify();

        $model = EntityWithVerifiedAt::withUnverified()->where('id', $model->id)->first();

        $this->assertNull($model->verified_at);
    }

    /** @test */
    public function it_can_skip_apply(): void
    {
        factory(EntityWithVerifiedAt::class, 3)->create([
            'verified_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithVerifiedAt::class, 2)->create([
            'verified_at' => null,
        ]);

        $entities = EntityWithVerifiedAtUnapplied::all();

        $this->assertCount(5, $entities);
    }
}
