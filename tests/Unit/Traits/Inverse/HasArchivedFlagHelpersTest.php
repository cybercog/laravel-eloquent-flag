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

use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithArchivedFlag;
use Cog\Tests\Flag\TestCase;

final class HasArchivedFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_is_archived_to_boolean(): void
    {
        $entity = factory(EntityWithArchivedFlag::class)->create([
            'is_archived' => 1,
        ]);

        $this->assertTrue($entity->is_archived);
    }

    /** @test */
    public function it_not_casts_is_archived_to_boolean(): void
    {
        $entity = factory(EntityWithArchivedFlag::class)->make([
            'is_archived' => null,
        ]);

        $this->assertNull($entity->is_archived);
    }

    /** @test */
    public function it_can_set_archived_flag(): void
    {
        $entity = factory(EntityWithArchivedFlag::class)->create([
            'is_archived' => false,
        ]);

        $entity->setArchivedFlag();

        $this->assertTrue($entity->is_archived);
    }

    /** @test */
    public function it_can_unset_archived_flag(): void
    {
        $entity = factory(EntityWithArchivedFlag::class)->create([
            'is_archived' => true,
        ]);

        $entity->unsetArchivedFlag();

        $this->assertFalse($entity->is_archived);
    }

    /** @test */
    public function it_can_check_if_entity_is_archived(): void
    {
        $archivedEntity = factory(EntityWithArchivedFlag::class)->create([
            'is_archived' => true,
        ]);

        $unarchivedEntity = factory(EntityWithArchivedFlag::class)->create([
            'is_archived' => false,
        ]);

        $this->assertTrue($archivedEntity->isArchived());
        $this->assertFalse($unarchivedEntity->isArchived());
    }

    /** @test */
    public function it_can_check_if_entity_is_unarchived(): void
    {
        $archivedEntity = factory(EntityWithArchivedFlag::class)->create([
            'is_archived' => true,
        ]);

        $unarchivedEntity = factory(EntityWithArchivedFlag::class)->create([
            'is_archived' => false,
        ]);

        $this->assertFalse($archivedEntity->isUnarchived());
        $this->assertTrue($unarchivedEntity->isUnarchived());
    }

    /** @test */
    public function it_can_close_entity(): void
    {
        $entity = factory(EntityWithArchivedFlag::class)->create([
            'is_archived' => false,
        ]);

        $entity->archive();

        $this->assertTrue($entity->is_archived);
    }

    /** @test */
    public function it_can_open_entity(): void
    {
        $entity = factory(EntityWithArchivedFlag::class)->create([
            'is_archived' => true,
        ]);

        $entity->unarchive();

        $this->assertFalse($entity->is_archived);
    }
}
