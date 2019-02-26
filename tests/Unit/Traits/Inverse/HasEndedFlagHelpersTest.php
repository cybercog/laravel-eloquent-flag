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

namespace Cog\Tests\Flag\Unit\Traits\Classic;

use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithEndedFlag;
use Cog\Tests\Flag\TestCase;

final class HasEndedFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_can_set_ended_flag(): void
    {
        $entity = factory(EntityWithEndedFlag::class)->create([
            'is_ended' => false,
        ]);

        $entity->setEndedFlag();

        $this->assertTrue($entity->is_ended);
    }

    /** @test */
    public function it_can_unset_ended_flag(): void
    {
        $entity = factory(EntityWithEndedFlag::class)->create([
            'is_ended' => true,
        ]);

        $entity->unsetEndedFlag();

        $this->assertFalse($entity->is_ended);
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
    public function it_can_check_if_entity_is_unended(): void
    {
        $endedEntity = factory(EntityWithEndedFlag::class)->create([
            'is_ended' => true,
        ]);

        $unendedEntity = factory(EntityWithEndedFlag::class)->create([
            'is_ended' => false,
        ]);

        $this->assertFalse($endedEntity->isUnended());
        $this->assertTrue($unendedEntity->isUnended());
    }

    /** @test */
    public function it_can_end_entity(): void
    {
        $entity = factory(EntityWithEndedFlag::class)->create([
            'is_ended' => false,
        ]);

        $entity->end();

        $this->assertTrue($entity->is_ended);
    }

    /** @test */
    public function it_can_unend_entity(): void
    {
        $entity = factory(EntityWithEndedFlag::class)->create([
            'is_ended' => true,
        ]);

        $entity->unend();

        $this->assertFalse($entity->is_ended);
    }
}
