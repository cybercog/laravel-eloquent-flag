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

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithAcceptedFlag;
use Cog\Tests\Flag\TestCase;

class HasAcceptedFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_can_set_accepted_flag(): void
    {
        $entity = factory(EntityWithAcceptedFlag::class)->create([
            'is_accepted' => false,
        ]);

        $entity->setAcceptedFlag();

        $this->assertTrue($entity->is_accepted);
    }

    /** @test */
    public function it_can_unset_accepted_flag(): void
    {
        $entity = factory(EntityWithAcceptedFlag::class)->create([
            'is_accepted' => true,
        ]);

        $entity->unsetAcceptedFlag();

        $this->assertFalse($entity->is_accepted);
    }

    /** @test */
    public function it_can_check_if_entity_is_accepted(): void
    {
        $acceptedEntity = factory(EntityWithAcceptedFlag::class)->create([
            'is_accepted' => true,
        ]);

        $rejectedEntity = factory(EntityWithAcceptedFlag::class)->create([
            'is_accepted' => false,
        ]);

        $this->assertTrue($acceptedEntity->isAccepted());
        $this->assertFalse($rejectedEntity->isAccepted());
    }

    /** @test */
    public function it_can_check_if_entity_is_rejected(): void
    {
        $acceptedEntity = factory(EntityWithAcceptedFlag::class)->create([
            'is_accepted' => true,
        ]);

        $rejectedEntity = factory(EntityWithAcceptedFlag::class)->create([
            'is_accepted' => false,
        ]);

        $this->assertFalse($acceptedEntity->isRejected());
        $this->assertTrue($rejectedEntity->isRejected());
    }

    /** @test */
    public function it_can_accept_entity(): void
    {
        $entity = factory(EntityWithAcceptedFlag::class)->create([
            'is_accepted' => false,
        ]);

        $entity->accept();

        $this->assertTrue($entity->is_accepted);
    }

    /** @test */
    public function it_can_reject_entity(): void
    {
        $entity = factory(EntityWithAcceptedFlag::class)->create([
            'is_accepted' => true,
        ]);

        $entity->reject();

        $this->assertFalse($entity->is_accepted);
    }
}
