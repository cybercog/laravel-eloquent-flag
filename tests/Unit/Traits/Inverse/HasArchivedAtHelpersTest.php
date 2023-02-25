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

namespace Cog\Tests\Laravel\Flag\Unit\Traits\Inverse;

use Cog\Tests\Laravel\Flag\Stubs\Models\Inverse\EntityWithArchivedAt;
use Cog\Tests\Laravel\Flag\TestCase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

final class HasArchivedAtHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_archived_at_to_datetime(): void
    {
        $entity = EntityWithArchivedAt::factory()->create([
            'archived_at' => '1986-03-28 00:00:00',
        ]);

        $this->assertInstanceOf(Carbon::class, $entity->archived_at);
        $this->assertSame('1986-03-28 00:00:00', $entity->archived_at->format('Y-m-d H:i:s'));
    }

    /** @test */
    public function it_can_check_if_entity_is_archived(): void
    {
        $archivedEntity = EntityWithArchivedAt::factory()->create([
            'archived_at' => Date::now(),
        ]);

        $unarchivedEntity = EntityWithArchivedAt::factory()->create([
            'archived_at' => null,
        ]);

        $this->assertTrue($archivedEntity->isArchived());
        $this->assertFalse($unarchivedEntity->isArchived());
    }

    /** @test */
    public function it_can_check_if_entity_is_not_archived(): void
    {
        $archivedEntity = EntityWithArchivedAt::factory()->create([
            'archived_at' => Date::now(),
        ]);

        $unarchivedEntity = EntityWithArchivedAt::factory()->create([
            'archived_at' => null,
        ]);

        $this->assertFalse($archivedEntity->isNotArchived());
        $this->assertTrue($unarchivedEntity->isNotArchived());
    }

    /** @test */
    public function it_can_archive(): void
    {
        $entity = EntityWithArchivedAt::factory()->create([
            'archived_at' => null,
        ]);

        $entity->archive();

        $this->assertNotNull($entity->archived_at);
    }

    /** @test */
    public function it_can_undo_archive(): void
    {
        $entity = EntityWithArchivedAt::factory()->create([
            'archived_at' => Date::now(),
        ]);

        $entity->undoArchive();

        $this->assertNull($entity->archived_at);
    }
}
