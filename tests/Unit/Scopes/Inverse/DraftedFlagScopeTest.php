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

namespace Cog\Tests\Flag\Unit\Scopes\Inverse;

use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithDraftedFlag;
use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithDraftedFlagApplied;
use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithDraftedFlagUnapplied;
use Cog\Tests\Flag\TestCase;

final class DraftedFlagScopeTest extends TestCase
{
    /** @test */
    public function it_get_without_global_scope_default(): void
    {
        factory(EntityWithDraftedFlag::class, 3)->create([
            'is_drafted' => true,
        ]);
        factory(EntityWithDraftedFlag::class, 2)->create([
            'is_drafted' => false,
        ]);

        $entities = EntityWithDraftedFlag::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_without_drafted(): void
    {
        factory(EntityWithDraftedFlag::class, 3)->create([
            'is_drafted' => true,
        ]);
        factory(EntityWithDraftedFlag::class, 2)->create([
            'is_drafted' => false,
        ]);

        $entities = EntityWithDraftedFlag::withoutDrafted()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_get_with_drafted(): void
    {
        factory(EntityWithDraftedFlag::class, 3)->create([
            'is_drafted' => true,
        ]);
        factory(EntityWithDraftedFlag::class, 2)->create([
            'is_drafted' => false,
        ]);

        $entities = EntityWithDraftedFlag::withDrafted()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_drafted(): void
    {
        factory(EntityWithDraftedFlag::class, 3)->create([
            'is_drafted' => true,
        ]);
        factory(EntityWithDraftedFlag::class, 2)->create([
            'is_drafted' => false,
        ]);

        $entities = EntityWithDraftedFlag::onlyDrafted()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_undo_draft_model(): void
    {
        $model = factory(EntityWithDraftedFlag::class)->create([
            'is_drafted' => true,
        ]);

        EntityWithDraftedFlag::where('id', $model->id)->undoDraft();

        $model = EntityWithDraftedFlag::where('id', $model->id)->first();

        $this->assertFalse($model->is_drafted);
    }

    /** @test */
    public function it_can_draft_model(): void
    {
        $model = factory(EntityWithDraftedFlag::class)->create([
            'is_drafted' => false,
        ]);

        EntityWithDraftedFlag::where('id', $model->id)->draft();

        $model = EntityWithDraftedFlag::withDrafted()->where('id', $model->id)->first();

        $this->assertTrue($model->is_drafted);
    }

    /** @test */
    public function it_can_skip_apply(): void
    {
        factory(EntityWithDraftedFlag::class, 3)->create([
            'is_drafted' => true,
        ]);
        factory(EntityWithDraftedFlag::class, 2)->create([
            'is_drafted' => false,
        ]);

        $entities = EntityWithDraftedFlagUnapplied::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_auto_apply(): void
    {
        factory(EntityWithDraftedFlag::class, 3)->create([
            'is_drafted' => true,
        ]);
        factory(EntityWithDraftedFlag::class, 2)->create([
            'is_drafted' => false,
        ]);

        $entities = EntityWithDraftedFlagApplied::all();

        $this->assertCount(2, $entities);
    }
}
