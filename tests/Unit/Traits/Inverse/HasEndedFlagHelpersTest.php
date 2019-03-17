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

use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithEndedFlag;
use Cog\Tests\Flag\TestCase;

final class HasEndedFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_is_ended_to_boolean(): void
    {
        $entity = factory(EntityWithEndedFlag::class)->create([
            'is_ended' => 1,
        ]);

        $this->assertTrue($entity->is_ended);
    }

    /** @test */
    public function it_not_casts_is_ended_to_boolean(): void
    {
        $entity = factory(EntityWithEndedFlag::class)->make([
            'is_ended' => null,
        ]);

        $this->assertNull($entity->is_ended);
    }

    /** @test */
    public function it_can_check_if_entity_is_ended(): void
    {
        $endedEntity = factory(EntityWithEndedFlag::class)->create([
            'is_ended' => true,
        ]);

        $unendedEntity = factory(EntityWithEndedFlag::class)->create([
            'is_ended' => false,
        ]);

        $this->assertTrue($endedEntity->isEnded());
        $this->assertFalse($unendedEntity->isEnded());
    }

    /** @test */
    public function it_can_check_if_entity_is_not_ended(): void
    {
        $endedEntity = factory(EntityWithEndedFlag::class)->create([
            'is_ended' => true,
        ]);

        $unendedEntity = factory(EntityWithEndedFlag::class)->create([
            'is_ended' => false,
        ]);

        $this->assertFalse($endedEntity->isNotEnded());
        $this->assertTrue($unendedEntity->isNotEnded());
    }

    /** @test */
    public function it_can_end(): void
    {
        $entity = factory(EntityWithEndedFlag::class)->create([
            'is_ended' => false,
        ]);

        $entity->end();

        $this->assertTrue($entity->is_ended);
    }

    /** @test */
    public function it_can_undo_end(): void
    {
        $entity = factory(EntityWithEndedFlag::class)->create([
            'is_ended' => true,
        ]);

        $entity->undoEnd();

        $this->assertFalse($entity->is_ended);
    }
}
