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

namespace Cog\Tests\Laravel\Flag\Unit\Scopes\Inverse;

use Cog\Tests\Laravel\Flag\Stubs\Models\Inverse\EntityWithArchivedFlag;
use Cog\Tests\Laravel\Flag\Stubs\Models\Inverse\EntityWithArchivedFlagApplied;
use Cog\Tests\Laravel\Flag\Stubs\Models\Inverse\EntityWithArchivedFlagUnapplied;
use Cog\Tests\Laravel\Flag\TestCase;

final class ArchivedFlagScopeTest extends TestCase
{
    /** @test */
    public function it_get_without_global_scope_default(): void
    {
        factory(EntityWithArchivedFlag::class, 3)->create([
            'is_archived' => true,
        ]);
        factory(EntityWithArchivedFlag::class, 2)->create([
            'is_archived' => false,
        ]);

        $entities = EntityWithArchivedFlag::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_without_archived(): void
    {
        factory(EntityWithArchivedFlag::class, 3)->create([
            'is_archived' => true,
        ]);
        factory(EntityWithArchivedFlag::class, 2)->create([
            'is_archived' => false,
        ]);

        $entities = EntityWithArchivedFlag::withoutArchived()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_get_with_archived(): void
    {
        factory(EntityWithArchivedFlag::class, 3)->create([
            'is_archived' => true,
        ]);
        factory(EntityWithArchivedFlag::class, 2)->create([
            'is_archived' => false,
        ]);

        $entities = EntityWithArchivedFlag::withArchived()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_archived(): void
    {
        factory(EntityWithArchivedFlag::class, 3)->create([
            'is_archived' => true,
        ]);
        factory(EntityWithArchivedFlag::class, 2)->create([
            'is_archived' => false,
        ]);

        $entities = EntityWithArchivedFlag::onlyArchived()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_undo_archive_model(): void
    {
        $model = factory(EntityWithArchivedFlag::class)->create([
            'is_archived' => true,
        ]);

        EntityWithArchivedFlag::where('id', $model->id)->undoArchive();

        $model = EntityWithArchivedFlag::where('id', $model->id)->first();

        $this->assertFalse($model->is_archived);
    }

    /** @test */
    public function it_can_archive_model(): void
    {
        $model = factory(EntityWithArchivedFlag::class)->create([
            'is_archived' => false,
        ]);

        EntityWithArchivedFlag::where('id', $model->id)->archive();

        $model = EntityWithArchivedFlag::withArchived()->where('id', $model->id)->first();

        $this->assertTrue($model->is_archived);
    }

    /** @test */
    public function it_can_skip_apply(): void
    {
        factory(EntityWithArchivedFlag::class, 3)->create([
            'is_archived' => true,
        ]);
        factory(EntityWithArchivedFlag::class, 2)->create([
            'is_archived' => false,
        ]);

        $entities = EntityWithArchivedFlagUnapplied::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_auto_apply(): void
    {
        factory(EntityWithArchivedFlag::class, 3)->create([
            'is_archived' => true,
        ]);
        factory(EntityWithArchivedFlag::class, 2)->create([
            'is_archived' => false,
        ]);

        $entities = EntityWithArchivedFlagApplied::all();

        $this->assertCount(2, $entities);
    }
}
