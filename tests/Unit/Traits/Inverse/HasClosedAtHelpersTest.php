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

use Cog\Tests\Laravel\Flag\Stubs\Models\Inverse\EntityWithClosedAt;
use Cog\Tests\Laravel\Flag\TestCase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

final class HasClosedAtHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_closed_at_to_datetime(): void
    {
        $entity = factory(EntityWithClosedAt::class)->create([
            'closed_at' => '1986-03-28 00:00:00',
        ]);

        $this->assertInstanceOf(Carbon::class, $entity->closed_at);
        $this->assertSame('1986-03-28 00:00:00', $entity->closed_at->format('Y-m-d H:i:s'));
    }

    /** @test */
    public function it_can_check_if_entity_is_closed(): void
    {
        $closedEntity = factory(EntityWithClosedAt::class)->create([
            'closed_at' => Date::now(),
        ]);

        $openedEntity = factory(EntityWithClosedAt::class)->create([
            'closed_at' => null,
        ]);

        $this->assertTrue($closedEntity->isClosed());
        $this->assertFalse($openedEntity->isClosed());
    }

    /** @test */
    public function it_can_check_if_entity_is_not_closed(): void
    {
        $closedEntity = factory(EntityWithClosedAt::class)->create([
            'closed_at' => Date::now(),
        ]);

        $openedEntity = factory(EntityWithClosedAt::class)->create([
            'closed_at' => null,
        ]);

        $this->assertFalse($closedEntity->isNotClosed());
        $this->assertTrue($openedEntity->isNotClosed());
    }

    /** @test */
    public function it_can_close(): void
    {
        $entity = factory(EntityWithClosedAt::class)->create([
            'closed_at' => null,
        ]);

        $entity->close();

        $this->assertNotNull($entity->closed_at);
    }

    /** @test */
    public function it_can_undo_close(): void
    {
        $entity = factory(EntityWithClosedAt::class)->create([
            'closed_at' => Date::now(),
        ]);

        $entity->undoClose();

        $this->assertNull($entity->closed_at);
    }
}
