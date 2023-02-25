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

use Cog\Tests\Laravel\Flag\Stubs\Models\Classic\EntityWithInvitedFlag;
use Cog\Tests\Laravel\Flag\TestCase;

final class HasInvitedFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_is_invited_to_boolean(): void
    {
        $entity = EntityWithInvitedFlag::factory()->create([
            'is_invited' => 1,
        ]);

        $this->assertTrue($entity->is_invited);
    }

    /** @test */
    public function it_not_casts_is_invited_to_boolean(): void
    {
        $entity = EntityWithInvitedFlag::factory()->make([
            'is_invited' => null,
        ]);

        $this->assertNull($entity->is_invited);
    }

    /** @test */
    public function it_can_check_if_entity_is_invited(): void
    {
        $invitedEntity = EntityWithInvitedFlag::factory()->create([
            'is_invited' => true,
        ]);

        $uninvitedEntity = EntityWithInvitedFlag::factory()->create([
            'is_invited' => false,
        ]);

        $this->assertTrue($invitedEntity->isInvited());
        $this->assertFalse($uninvitedEntity->isInvited());
    }

    /** @test */
    public function it_can_check_if_entity_is_not_invited(): void
    {
        $invitedEntity = EntityWithInvitedFlag::factory()->create([
            'is_invited' => true,
        ]);

        $uninvitedEntity = EntityWithInvitedFlag::factory()->create([
            'is_invited' => false,
        ]);

        $this->assertFalse($invitedEntity->isNotInvited());
        $this->assertTrue($uninvitedEntity->isNotInvited());
    }

    /** @test */
    public function it_can_invite(): void
    {
        $entity = EntityWithInvitedFlag::factory()->create([
            'is_invited' => false,
        ]);

        $entity->invite();

        $this->assertTrue($entity->is_invited);
    }

    /** @test */
    public function it_can_undo_invite(): void
    {
        $entity = EntityWithInvitedFlag::factory()->create([
            'is_invited' => true,
        ]);

        $entity->undoInvite();

        $this->assertFalse($entity->is_invited);
    }
}
