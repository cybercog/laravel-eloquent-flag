<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Tests\Flag\Unit\Traits\Classic;

use Carbon\Carbon;
use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithEndedAt;
use Cog\Tests\Flag\TestCase;

class HasEndedAtHelpersTest extends TestCase
{
    /** @test */
    public function it_can_set_ended_flag()
    {
        $entity = factory(EntityWithEndedAt::class)->create([
            'ended_at' => null,
        ]);

        $entity->setEndedFlag();

        $this->assertNotNull($entity->ended_at);
    }

    /** @test */
    public function it_can_unset_ended_flag()
    {
        $entity = factory(EntityWithEndedAt::class)->create([
            'ended_at' => Carbon::now(),
        ]);

        $entity->unsetEndedFlag();

        $this->assertNull($entity->ended_at);
    }

    /** @test */
    public function it_can_check_if_entity_is_ended()
    {
        $endedEntity = factory(EntityWithEndedAt::class)->create([
            'ended_at' => Carbon::now(),
        ]);

        $unendedEntity = factory(EntityWithEndedAt::class)->create([
            'ended_at' => null,
        ]);

        $this->assertTrue($endedEntity->isEnded());
        $this->assertFalse($unendedEntity->isEnded());
    }

    /** @test */
    public function it_can_check_if_entity_is_unended()
    {
        $endedEntity = factory(EntityWithEndedAt::class)->create([
            'ended_at' => Carbon::now(),
        ]);

        $unendedEntity = factory(EntityWithEndedAt::class)->create([
            'ended_at' => null,
        ]);

        $this->assertFalse($endedEntity->isUnended());
        $this->assertTrue($unendedEntity->isUnended());
    }

    /** @test */
    public function it_can_end_entity()
    {
        $entity = factory(EntityWithEndedAt::class)->create([
            'ended_at' => null,
        ]);

        $entity->end();

        $this->assertNotNull($entity->ended_at);
    }

    /** @test */
    public function it_can_unend_entity()
    {
        $entity = factory(EntityWithEndedAt::class)->create([
            'ended_at' => Carbon::now(),
        ]);

        $entity->unend();

        $this->assertNull($entity->ended_at);
    }
}
