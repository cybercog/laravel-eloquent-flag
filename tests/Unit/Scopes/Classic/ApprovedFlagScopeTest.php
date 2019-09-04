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

namespace Cog\Tests\Flag\Unit\Scopes\Classic;

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithApprovedFlag;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithApprovedFlagApplied;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithApprovedFlagUnapplied;
use Cog\Tests\Flag\TestCase;

final class ApprovedFlagScopeTest extends TestCase
{
    /** @test */
    public function it_get_without_global_scope_default(): void
    {
        factory(EntityWithApprovedFlag::class, 3)->create([
            'is_approved' => true,
        ]);
        factory(EntityWithApprovedFlag::class, 2)->create([
            'is_approved' => false,
        ]);

        $entities = EntityWithApprovedFlag::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_without_not_approved(): void
    {
        factory(EntityWithApprovedFlag::class, 3)->create([
            'is_approved' => true,
        ]);
        factory(EntityWithApprovedFlag::class, 2)->create([
            'is_approved' => false,
        ]);

        $entities = EntityWithApprovedFlag::withoutNotApproved()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_not_approved(): void
    {
        factory(EntityWithApprovedFlag::class, 3)->create([
            'is_approved' => true,
        ]);
        factory(EntityWithApprovedFlag::class, 2)->create([
            'is_approved' => false,
        ]);

        $entities = EntityWithApprovedFlag::withNotApproved()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_not_approved(): void
    {
        factory(EntityWithApprovedFlag::class, 3)->create([
            'is_approved' => true,
        ]);
        factory(EntityWithApprovedFlag::class, 2)->create([
            'is_approved' => false,
        ]);

        $entities = EntityWithApprovedFlag::onlyNotApproved()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_approve_model(): void
    {
        $model = factory(EntityWithApprovedFlag::class)->create([
            'is_approved' => false,
        ]);

        EntityWithApprovedFlag::where('id', $model->id)->approve();

        $model = EntityWithApprovedFlag::where('id', $model->id)->first();

        $this->assertTrue($model->is_approved);
    }

    /** @test */
    public function it_can_undo_approve_model(): void
    {
        $model = factory(EntityWithApprovedFlag::class)->create([
            'is_approved' => true,
        ]);

        EntityWithApprovedFlag::where('id', $model->id)->undoApprove();

        $model = EntityWithApprovedFlag::withNotApproved()->where('id', $model->id)->first();

        $this->assertFalse($model->is_approved);
    }

    /** @test */
    public function it_can_skip_apply(): void
    {
        factory(EntityWithApprovedFlag::class, 3)->create([
            'is_approved' => true,
        ]);
        factory(EntityWithApprovedFlag::class, 2)->create([
            'is_approved' => false,
        ]);

        $entities = EntityWithApprovedFlagUnapplied::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_auto_apply(): void
    {
        factory(EntityWithApprovedFlag::class, 3)->create([
            'is_approved' => true,
        ]);
        factory(EntityWithApprovedFlag::class, 2)->create([
            'is_approved' => false,
        ]);

        $entities = EntityWithApprovedFlagApplied::all();

        $this->assertCount(3, $entities);
    }
}
