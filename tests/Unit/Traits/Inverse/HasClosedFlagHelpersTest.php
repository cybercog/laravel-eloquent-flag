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

use Cog\Tests\Laravel\Flag\Stubs\Models\Inverse\EntityWithClosedFlag;
use Cog\Tests\Laravel\Flag\TestCase;

final class HasClosedFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_is_closed_to_boolean(): void
    {
        $entity = factory(EntityWithClosedFlag::class)->create([
            'is_closed' => 1,
        ]);

        $this->assertTrue($entity->is_closed);
    }

    /** @test */
    public function it_not_casts_is_closed_to_boolean(): void
    {
        $entity = factory(EntityWithClosedFlag::class)->make([
            'is_closed' => null,
        ]);

        $this->assertNull($entity->is_closed);
    }

    /** @test */
    public function it_can_check_if_entity_is_closed(): void
    {
        $closedEntity = factory(EntityWithClosedFlag::class)->create([
            'is_closed' => true,
        ]);

        $openedEntity = factory(EntityWithClosedFlag::class)->create([
            'is_closed' => false,
        ]);

        $this->assertTrue($closedEntity->isClosed());
        $this->assertFalse($openedEntity->isClosed());
    }

    /** @test */
    public function it_can_check_if_entity_is_not_closed(): void
    {
        $closedEntity = factory(EntityWithClosedFlag::class)->create([
            'is_closed' => true,
        ]);

        $openedEntity = factory(EntityWithClosedFlag::class)->create([
            'is_closed' => false,
        ]);

        $this->assertFalse($closedEntity->isNotClosed());
        $this->assertTrue($openedEntity->isNotClosed());
    }

    /** @test */
    public function it_can_close(): void
    {
        $entity = factory(EntityWithClosedFlag::class)->create([
            'is_closed' => false,
        ]);

        $entity->close();

        $this->assertTrue($entity->is_closed);
    }

    /** @test */
    public function it_can_undo_close(): void
    {
        $entity = factory(EntityWithClosedFlag::class)->create([
            'is_closed' => true,
        ]);

        $entity->undoClose();

        $this->assertFalse($entity->is_closed);
    }
}
