<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Tests\Flag\Unit\Scopes\Inverse;

use Carbon\Carbon;
use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithArchivedAt;
use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithArchivedAtUnapplied;
use Cog\Tests\Flag\TestCase;

class ArchivedAtScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_not_archived()
    {
        factory(EntityWithArchivedAt::class, 2)->create([
            'archived_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithArchivedAt::class, 3)->create([
            'archived_at' => null,
        ]);

        $entities = EntityWithArchivedAt::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_archived()
    {
        factory(EntityWithArchivedAt::class, 2)->create([
            'archived_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithArchivedAt::class, 3)->create([
            'archived_at' => null,
        ]);

        $entities = EntityWithArchivedAt::withoutArchived()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_archived()
    {
        factory(EntityWithArchivedAt::class, 2)->create([
            'archived_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithArchivedAt::class, 3)->create([
            'archived_at' => null,
        ]);

        $entities = EntityWithArchivedAt::withArchived()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_archived()
    {
        factory(EntityWithArchivedAt::class, 2)->create([
            'archived_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithArchivedAt::class, 3)->create([
            'archived_at' => null,
        ]);

        $entities = EntityWithArchivedAt::onlyArchived()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_unarchive_model()
    {
        $model = factory(EntityWithArchivedAt::class)->create([
            'archived_at' => Carbon::now()->subDay(),
        ]);

        EntityWithArchivedAt::where('id', $model->id)->unarchive();

        $model = EntityWithArchivedAt::where('id', $model->id)->first();

        $this->assertNull($model->archived_at);
    }

    /** @test */
    public function it_can_archive_model()
    {
        $model = factory(EntityWithArchivedAt::class)->create([
            'archived_at' => null,
        ]);

        EntityWithArchivedAt::where('id', $model->id)->archive();

        $model = EntityWithArchivedAt::withArchived()->where('id', $model->id)->first();

        $this->assertNotNull($model->archived_at);
    }

    /** @test */
    public function it_can_skip_apply()
    {
        factory(EntityWithArchivedAt::class, 3)->create([
            'archived_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithArchivedAt::class, 2)->create([
            'archived_at' => null,
        ]);

        $entities = EntityWithArchivedAtUnapplied::all();

        $this->assertCount(5, $entities);
    }
}
