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

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithActiveFlag;
use Cog\Tests\Flag\TestCase;

final class HasActiveFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_is_active_to_boolean(): void
    {
        $entity = factory(EntityWithActiveFlag::class)->create([
            'is_active' => 1,
        ]);

        $this->assertTrue($entity->is_active);
    }

    /** @test */
    public function it_not_casts_is_active_to_boolean(): void
    {
        $entity = factory(EntityWithActiveFlag::class)->make([
            'is_active' => null,
        ]);

        $this->assertNull($entity->is_active);
    }

    /** @test */
    public function it_can_check_if_entity_is_active(): void
    {
        $activatedEntity = factory(EntityWithActiveFlag::class)->create([
            'is_active' => true,
        ]);

        $deactivatedEntity = factory(EntityWithActiveFlag::class)->create([
            'is_active' => false,
        ]);

        $this->assertTrue($activatedEntity->isActivated());
        $this->assertFalse($deactivatedEntity->isActivated());
    }

    /** @test */
    public function it_can_check_if_entity_is_not_activated(): void
    {
        $activatedEntity = factory(EntityWithActiveFlag::class)->create([
            'is_active' => true,
        ]);

        $deactivatedEntity = factory(EntityWithActiveFlag::class)->create([
            'is_active' => false,
        ]);

        $this->assertFalse($activatedEntity->isNotActivated());
        $this->assertTrue($deactivatedEntity->isNotActivated());
    }

    /** @test */
    public function it_can_accept_entity(): void
    {
        $entity = factory(EntityWithActiveFlag::class)->create([
            'is_active' => false,
        ]);

        $entity->activate();

        $this->assertTrue($entity->is_active);
    }

    /** @test */
    public function it_can_reject_entity(): void
    {
        $entity = factory(EntityWithActiveFlag::class)->create([
            'is_active' => true,
        ]);

        $entity->deactivate();

        $this->assertFalse($entity->is_active);
    }
}
