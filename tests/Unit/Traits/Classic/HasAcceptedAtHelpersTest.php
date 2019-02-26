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

class HasAcceptedAtHelpersTest extends TestCase
{
    /** @test */
    public function it_can_set_accepted_flag(): void
    {
        $entity = factory(EntityWithAcceptedAt::class)->create([
            'accepted_at' => null,
        ]);

        $entity->setAcceptedFlag();

        $this->assertNotNull($entity->accepted_at);
    }

    /** @test */
    public function it_can_unset_accepted_flag(): void
    {
        $entity = factory(EntityWithAcceptedAt::class)->create([
            'accepted_at' => Carbon::now(),
        ]);

        $entity->unsetAcceptedFlag();

        $this->assertNull($entity->accepted_at);
    }

    /** @test */
    public function it_can_check_if_entity_is_accepted(): void
    {
        $acceptedEntity = factory(EntityWithAcceptedAt::class)->create([
            'accepted_at' => Carbon::now(),
        ]);

        $rejectedEntity = factory(EntityWithAcceptedAt::class)->create([
            'accepted_at' => null,
        ]);

        $this->assertTrue($acceptedEntity->isAccepted());
        $this->assertFalse($rejectedEntity->isAccepted());
    }

    /** @test */
    public function it_can_check_if_entity_is_rejected(): void
    {
        $acceptedEntity = factory(EntityWithAcceptedAt::class)->create([
            'accepted_at' => Carbon::now(),
        ]);

        $rejectedEntity = factory(EntityWithAcceptedAt::class)->create([
            'accepted_at' => null,
        ]);

        $this->assertFalse($acceptedEntity->isRejected());
        $this->assertTrue($rejectedEntity->isRejected());
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
            'accepted_at' => Carbon::now(),
        ]);

        $entity->reject();

        $this->assertNull($entity->accepted_at);
    }
}
