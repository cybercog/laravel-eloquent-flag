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

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithInvitedFlag;
use Cog\Tests\Flag\TestCase;

class HasInvitedFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_can_set_invited_flag(): void
    {
        $entity = factory(EntityWithInvitedFlag::class)->create([
            'is_invited' => false,
        ]);

        $entity->setInvitedFlag();

        $this->assertTrue($entity->is_invited);
    }

    /** @test */
    public function it_can_unset_invited_flag(): void
    {
        $entity = factory(EntityWithInvitedFlag::class)->create([
            'is_invited' => true,
        ]);

        $entity->unsetInvitedFlag();

        $this->assertFalse($entity->is_invited);
    }

    /** @test */
    public function it_can_check_if_entity_is_invited(): void
    {
        $invitedEntity = factory(EntityWithInvitedFlag::class)->create([
            'is_invited' => true,
        ]);

        $uninvitedEntity = factory(EntityWithInvitedFlag::class)->create([
            'is_invited' => false,
        ]);

        $this->assertTrue($invitedEntity->isInvited());
        $this->assertFalse($uninvitedEntity->isInvited());
    }

    /** @test */
    public function it_can_check_if_entity_is_uninvited(): void
    {
        $invitedEntity = factory(EntityWithInvitedFlag::class)->create([
            'is_invited' => true,
        ]);

        $uninvitedEntity = factory(EntityWithInvitedFlag::class)->create([
            'is_invited' => false,
        ]);

        $this->assertFalse($invitedEntity->isUninvited());
        $this->assertTrue($uninvitedEntity->isUninvited());
    }

    /** @test */
    public function it_can_invite_entity(): void
    {
        $entity = factory(EntityWithInvitedFlag::class)->create([
            'is_invited' => false,
        ]);

        $entity->invite();

        $this->assertTrue($entity->is_invited);
    }

    /** @test */
    public function it_can_uninvite_entity(): void
    {
        $entity = factory(EntityWithInvitedFlag::class)->create([
            'is_invited' => true,
        ]);

        $entity->uninvite();

        $this->assertFalse($entity->is_invited);
    }
}
