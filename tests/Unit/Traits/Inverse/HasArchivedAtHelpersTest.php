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

namespace Cog\Tests\Flag\Unit\Traits\Inverse;

use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithArchivedAt;
use Cog\Tests\Flag\TestCase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

final class HasArchivedAtHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_archived_at_to_datetime(): void
    {
        $entity = factory(EntityWithArchivedAt::class)->create([
            'archived_at' => '1986-03-28 00:00:00',
        ]);

        $this->assertInstanceOf(Carbon::class, $entity->archived_at);
        $this->assertSame('1986-03-28 00:00:00', $entity->archived_at->format('Y-m-d H:i:s'));
    }

    /** @test */
    public function it_can_check_if_entity_is_archived(): void
    {
        $archivedEntity = factory(EntityWithArchivedAt::class)->create([
            'archived_at' => Date::now(),
        ]);

        $unarchivedEntity = factory(EntityWithArchivedAt::class)->create([
            'archived_at' => null,
        ]);

        $this->assertTrue($archivedEntity->isArchived());
        $this->assertFalse($unarchivedEntity->isArchived());
    }

    /** @test */
    public function it_can_check_if_entity_is_unarchived(): void
    {
        $archivedEntity = factory(EntityWithArchivedAt::class)->create([
            'archived_at' => Date::now(),
        ]);

        $unarchivedEntity = factory(EntityWithArchivedAt::class)->create([
            'archived_at' => null,
        ]);

        $this->assertFalse($archivedEntity->isUnarchived());
        $this->assertTrue($unarchivedEntity->isUnarchived());
    }

    /** @test */
    public function it_can_archive_entity(): void
    {
        $entity = factory(EntityWithArchivedAt::class)->create([
            'archived_at' => null,
        ]);

        $entity->archive();

        $this->assertNotNull($entity->archived_at);
    }

    /** @test */
    public function it_can_unarchive_entity(): void
    {
        $entity = factory(EntityWithArchivedAt::class)->create([
            'archived_at' => Date::now(),
        ]);

        $entity->unarchive();

        $this->assertNull($entity->archived_at);
    }
}
