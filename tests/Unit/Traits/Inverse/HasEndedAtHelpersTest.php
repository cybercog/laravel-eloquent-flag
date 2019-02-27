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

use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithEndedAt;
use Cog\Tests\Flag\TestCase;
use Illuminate\Support\Carbon;

final class HasEndedAtHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_ended_at_to_datetime(): void
    {
        $entity = factory(EntityWithEndedAt::class)->create([
            'ended_at' => '1986-03-28 00:00:00',
        ]);

        $this->assertInstanceOf(Carbon::class, $entity->ended_at);
        $this->assertSame('1986-03-28 00:00:00', $entity->ended_at->format('Y-m-d H:i:s'));
    }

    /** @test */
    public function it_can_set_ended_flag(): void
    {
        $entity = factory(EntityWithEndedAt::class)->create([
            'ended_at' => null,
        ]);

        $entity->setEndedFlag();

        $this->assertNotNull($entity->ended_at);
    }

    /** @test */
    public function it_can_unset_ended_flag(): void
    {
        $entity = factory(EntityWithEndedAt::class)->create([
            'ended_at' => Carbon::now(),
        ]);

        $entity->unsetEndedFlag();

        $this->assertNull($entity->ended_at);
    }

    /** @test */
    public function it_can_check_if_entity_is_ended(): void
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
    public function it_can_check_if_entity_is_unended(): void
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
    public function it_can_end_entity(): void
    {
        $entity = factory(EntityWithEndedAt::class)->create([
            'ended_at' => null,
        ]);

        $entity->end();

        $this->assertNotNull($entity->ended_at);
    }

    /** @test */
    public function it_can_unend_entity(): void
    {
        $entity = factory(EntityWithEndedAt::class)->create([
            'ended_at' => Carbon::now(),
        ]);

        $entity->unend();

        $this->assertNull($entity->ended_at);
    }
}
