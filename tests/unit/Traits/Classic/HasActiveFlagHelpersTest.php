<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Tests\Unit\Traits\Classic;

use Cog\Flag\Tests\Stubs\Models\Classic\EntityWithActiveFlag;
use Cog\Flag\Tests\TestCase;

/**
 * Class HasActiveFlagHelpersTest.
 *
 * @package Cog\Flag\Tests\Unit\Traits\Classic
 */
class HasActiveFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_can_set_active_flag()
    {
        $entity = factory(EntityWithActiveFlag::class, 1)->create([
            'is_active' => false,
        ]);

        $entity->setActivatedFlag();

        $this->assertTrue($entity->is_active);
    }

    /** @test */
    public function it_can_unset_active_flag()
    {
        $entity = factory(EntityWithActiveFlag::class, 1)->create([
            'is_active' => true,
        ]);

        $entity->unsetActivatedFlag();

        $this->assertFalse($entity->is_active);
    }

    /** @test */
    public function it_can_check_if_entity_is_active()
    {
        $activatedEntity = factory(EntityWithActiveFlag::class, 1)->create([
            'is_active' => true,
        ]);

        $deactivatedEntity = factory(EntityWithActiveFlag::class, 1)->create([
            'is_active' => false,
        ]);

        $this->assertTrue($activatedEntity->isActivated());
        $this->assertFalse($deactivatedEntity->isActivated());
    }

    /** @test */
    public function it_can_check_if_entity_is_deactivated()
    {
        $activatedEntity = factory(EntityWithActiveFlag::class, 1)->create([
            'is_active' => true,
        ]);

        $deactivatedEntity = factory(EntityWithActiveFlag::class, 1)->create([
            'is_active' => false,
        ]);

        $this->assertFalse($activatedEntity->isDeactivated());
        $this->assertTrue($deactivatedEntity->isDeactivated());
    }

    /** @test */
    public function it_can_accept_entity()
    {
        $entity = factory(EntityWithActiveFlag::class, 1)->create([
            'is_active' => false,
        ]);

        $entity->activate();

        $this->assertTrue($entity->is_active);
    }

    /** @test */
    public function it_can_reject_entity()
    {
        $entity = factory(EntityWithActiveFlag::class, 1)->create([
            'is_active' => true,
        ]);

        $entity->deactivate();

        $this->assertFalse($entity->is_active);
    }
}
