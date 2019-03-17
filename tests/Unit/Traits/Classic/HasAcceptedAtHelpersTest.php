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

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithAcceptedAt;
use Cog\Tests\Flag\TestCase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

final class HasAcceptedAtHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_accepted_at_to_datetime(): void
    {
        $entity = factory(EntityWithAcceptedAt::class)->create([
            'accepted_at' => '1986-03-28 00:00:00',
        ]);

        $this->assertInstanceOf(Carbon::class, $entity->accepted_at);
        $this->assertSame('1986-03-28 00:00:00', $entity->accepted_at->format('Y-m-d H:i:s'));
    }

    /** @test */
    public function it_can_check_if_entity_is_accepted(): void
    {
        $acceptedEntity = factory(EntityWithAcceptedAt::class)->create([
            'accepted_at' => Date::now(),
        ]);

        $rejectedEntity = factory(EntityWithAcceptedAt::class)->create([
            'accepted_at' => null,
        ]);

        $this->assertTrue($acceptedEntity->isAccepted());
        $this->assertFalse($rejectedEntity->isAccepted());
    }

    /** @test */
    public function it_can_check_if_entity_is_not_accepted(): void
    {
        $acceptedEntity = factory(EntityWithAcceptedAt::class)->create([
            'accepted_at' => Date::now(),
        ]);

        $rejectedEntity = factory(EntityWithAcceptedAt::class)->create([
            'accepted_at' => null,
        ]);

        $this->assertFalse($acceptedEntity->isNotAccepted());
        $this->assertTrue($rejectedEntity->isNotAccepted());
    }

    /** @test */
    public function it_can_accept_entity(): void
    {
        $entity = factory(EntityWithAcceptedAt::class)->create([
            'accepted_at' => null,
        ]);

        $entity->accept();

        $this->assertNotNull($entity->accepted_at);
    }

    /** @test */
    public function it_can_reject_entity(): void
    {
        $entity = factory(EntityWithAcceptedAt::class)->create([
            'accepted_at' => Date::now(),
        ]);

        $entity->reject();

        $this->assertNull($entity->accepted_at);
    }
}
