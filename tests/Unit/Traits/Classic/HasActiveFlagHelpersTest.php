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

namespace Cog\Tests\Laravel\Flag\Unit\Traits\Classic;

use Cog\Tests\Laravel\Flag\Stubs\Models\Classic\EntityWithActiveFlag;
use Cog\Tests\Laravel\Flag\TestCase;

final class HasActiveFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_is_active_to_boolean(): void
    {
        $entity = EntityWithActiveFlag::factory()->create([
            'is_active' => 1,
        ]);

        $this->assertTrue($entity->is_active);
    }

    /** @test */
    public function it_not_casts_is_active_to_boolean(): void
    {
        $entity = EntityWithActiveFlag::factory()->make([
            'is_active' => null,
        ]);

        $this->assertNull($entity->is_active);
    }

    /** @test */
    public function it_can_check_if_entity_is_active(): void
    {
        $activatedEntity = EntityWithActiveFlag::factory()->create([
            'is_active' => true,
        ]);

        $deactivatedEntity = EntityWithActiveFlag::factory()->create([
            'is_active' => false,
        ]);

        $this->assertTrue($activatedEntity->isActivated());
        $this->assertFalse($deactivatedEntity->isActivated());
    }

    /** @test */
    public function it_can_check_if_entity_is_not_activated(): void
    {
        $activatedEntity = EntityWithActiveFlag::factory()->create([
            'is_active' => true,
        ]);

        $deactivatedEntity = EntityWithActiveFlag::factory()->create([
            'is_active' => false,
        ]);

        $this->assertFalse($activatedEntity->isNotActivated());
        $this->assertTrue($deactivatedEntity->isNotActivated());
    }

    /** @test */
    public function it_can_activate(): void
    {
        $entity = EntityWithActiveFlag::factory()->create([
            'is_active' => false,
        ]);

        $entity->activate();

        $this->assertTrue($entity->is_active);
    }

    /** @test */
    public function it_can_undo_activate(): void
    {
        $entity = EntityWithActiveFlag::factory()->create([
            'is_active' => true,
        ]);

        $entity->undoActivate();

        $this->assertFalse($entity->is_active);
    }
}
