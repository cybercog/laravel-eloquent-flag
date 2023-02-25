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

use Cog\Tests\Laravel\Flag\Stubs\Models\Inverse\EntityWithArchivedFlag;
use Cog\Tests\Laravel\Flag\TestCase;

final class HasArchivedFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_is_archived_to_boolean(): void
    {
        $entity = EntityWithArchivedFlag::factory()->create([
            'is_archived' => 1,
        ]);

        $this->assertTrue($entity->is_archived);
    }

    /** @test */
    public function it_not_casts_is_archived_to_boolean(): void
    {
        $entity = EntityWithArchivedFlag::factory()->make([
            'is_archived' => null,
        ]);

        $this->assertNull($entity->is_archived);
    }

    /** @test */
    public function it_can_check_if_entity_is_archived(): void
    {
        $archivedEntity = EntityWithArchivedFlag::factory()->create([
            'is_archived' => true,
        ]);

        $unarchivedEntity = EntityWithArchivedFlag::factory()->create([
            'is_archived' => false,
        ]);

        $this->assertTrue($archivedEntity->isArchived());
        $this->assertFalse($unarchivedEntity->isArchived());
    }

    /** @test */
    public function it_can_check_if_entity_is_not_archived(): void
    {
        $archivedEntity = EntityWithArchivedFlag::factory()->create([
            'is_archived' => true,
        ]);

        $unarchivedEntity = EntityWithArchivedFlag::factory()->create([
            'is_archived' => false,
        ]);

        $this->assertFalse($archivedEntity->isNotArchived());
        $this->assertTrue($unarchivedEntity->isNotArchived());
    }

    /** @test */
    public function it_can_archive(): void
    {
        $entity = EntityWithArchivedFlag::factory()->create([
            'is_archived' => false,
        ]);

        $entity->archive();

        $this->assertTrue($entity->is_archived);
    }

    /** @test */
    public function it_can_undo_archive(): void
    {
        $entity = EntityWithArchivedFlag::factory()->create([
            'is_archived' => true,
        ]);

        $entity->undoArchive();

        $this->assertFalse($entity->is_archived);
    }
}
