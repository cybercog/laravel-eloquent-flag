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

namespace Cog\Tests\Laravel\Flag\Unit\Scopes\Classic;

use Cog\Tests\Laravel\Flag\Stubs\Models\Classic\EntityWithApprovedAt;
use Cog\Tests\Laravel\Flag\Stubs\Models\Classic\EntityWithApprovedAtApplied;
use Cog\Tests\Laravel\Flag\Stubs\Models\Classic\EntityWithApprovedAtUnapplied;
use Cog\Tests\Laravel\Flag\TestCase;
use Illuminate\Support\Facades\Date;

final class ApprovedAtScopeTest extends TestCase
{
    /** @test */
    public function it_get_without_global_scope_default(): void
    {
        factory(EntityWithApprovedAt::class, 3)->create([
            'approved_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithApprovedAt::class, 2)->create([
            'approved_at' => null,
        ]);

        $entities = EntityWithApprovedAt::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_without_not_approved(): void
    {
        factory(EntityWithApprovedAt::class, 3)->create([
            'approved_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithApprovedAt::class, 2)->create([
            'approved_at' => null,
        ]);

        $entities = EntityWithApprovedAt::withoutNotApproved()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_not_approved(): void
    {
        factory(EntityWithApprovedAt::class, 3)->create([
            'approved_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithApprovedAt::class, 2)->create([
            'approved_at' => null,
        ]);

        $entities = EntityWithApprovedAt::withNotApproved()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_not_approved(): void
    {
        factory(EntityWithApprovedAt::class, 3)->create([
            'approved_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithApprovedAt::class, 2)->create([
            'approved_at' => null,
        ]);

        $entities = EntityWithApprovedAt::onlyNotApproved()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_approve_model(): void
    {
        $model = factory(EntityWithApprovedAt::class)->create([
            'approved_at' => null,
        ]);

        EntityWithApprovedAt::where('id', $model->id)->approve();

        $model = EntityWithApprovedAt::where('id', $model->id)->first();

        $this->assertNotNull($model->approved_at);
    }

    /** @test */
    public function it_can_undo_approve_model(): void
    {
        $model = factory(EntityWithApprovedAt::class)->create([
            'approved_at' => Date::now()->subDay(),
        ]);

        EntityWithApprovedAt::where('id', $model->id)->undoApprove();

        $model = EntityWithApprovedAt::withNotApproved()->where('id', $model->id)->first();

        $this->assertNull($model->approved_at);
    }

    /** @test */
    public function it_can_skip_apply(): void
    {
        factory(EntityWithApprovedAt::class, 3)->create([
            'approved_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithApprovedAt::class, 2)->create([
            'approved_at' => null,
        ]);

        $entities = EntityWithApprovedAtUnapplied::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_auto_apply(): void
    {
        factory(EntityWithApprovedAt::class, 3)->create([
            'approved_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithApprovedAt::class, 2)->create([
            'approved_at' => null,
        ]);

        $entities = EntityWithApprovedAtApplied::all();

        $this->assertCount(3, $entities);
    }
}
