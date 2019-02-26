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

use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithArchivedFlag;
use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithArchivedFlagUnapplied;
use Cog\Tests\Flag\TestCase;

final class ArchivedFlagScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_not_archived(): void
    {
        factory(EntityWithArchivedFlag::class, 2)->create([
            'is_archived' => true,
        ]);
        factory(EntityWithArchivedFlag::class, 3)->create([
            'is_archived' => false,
        ]);

        $entities = EntityWithArchivedFlag::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_archived(): void
    {
        factory(EntityWithArchivedFlag::class, 2)->create([
            'is_archived' => true,
        ]);
        factory(EntityWithArchivedFlag::class, 3)->create([
            'is_archived' => false,
        ]);

        $entities = EntityWithArchivedFlag::withoutArchived()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_archived(): void
    {
        factory(EntityWithArchivedFlag::class, 2)->create([
            'is_archived' => true,
        ]);
        factory(EntityWithArchivedFlag::class, 3)->create([
            'is_archived' => false,
        ]);

        $entities = EntityWithArchivedFlag::withArchived()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_archived(): void
    {
        factory(EntityWithArchivedFlag::class, 2)->create([
            'is_archived' => true,
        ]);
        factory(EntityWithArchivedFlag::class, 3)->create([
            'is_archived' => false,
        ]);

        $entities = EntityWithArchivedFlag::onlyArchived()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_unarchive_model(): void
    {
        $model = factory(EntityWithArchivedFlag::class)->create([
            'is_archived' => true,
        ]);

        EntityWithArchivedFlag::where('id', $model->id)->unarchive();

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
}
