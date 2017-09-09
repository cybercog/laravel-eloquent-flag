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

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithAcceptedFlag;
use Cog\Tests\Flag\TestCase;

/**
 * Class HasAcceptedFlagHelpersTest.
 *
 * @package Cog\Tests\Flag\Unit\Traits\Classic
 */
class HasAcceptedFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_can_set_accepted_flag()
    {
        $entity = factory(EntityWithAcceptedFlag::class)->create([
            'is_accepted' => false,
        ]);

        $entity->setAcceptedFlag();

        $this->assertTrue($entity->is_accepted);
    }

    /** @test */
    public function it_can_unset_accepted_flag()
    {
        $entity = factory(EntityWithAcceptedFlag::class)->create([
            'is_accepted' => true,
        ]);

        $entity->unsetAcceptedFlag();

        $this->assertFalse($entity->is_accepted);
    }

    /** @test */
    public function it_can_check_if_entity_is_accepted()
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
    public function it_can_check_if_entity_is_rejected()
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
    public function it_can_accept_entity()
    {
        $entity = factory(EntityWithAcceptedFlag::class)->create([
            'is_accepted' => false,
        ]);

        $entity->accept();

        $this->assertTrue($entity->is_accepted);
    }

    /** @test */
    public function it_can_reject_entity()
    {
        $entity = factory(EntityWithAcceptedFlag::class)->create([
            'is_accepted' => true,
        ]);

        $entity->reject();

        $this->assertFalse($entity->is_accepted);
    }
}
