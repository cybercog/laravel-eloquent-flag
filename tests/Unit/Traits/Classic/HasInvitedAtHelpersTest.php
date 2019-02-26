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

use Carbon\Carbon;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithInvitedAt;
use Cog\Tests\Flag\TestCase;

class HasInvitedAtHelpersTest extends TestCase
{
    /** @test */
    public function it_can_set_invited_flag()
    {
        $entity = factory(EntityWithInvitedAt::class)->create([
            'invited_at' => null,
        ]);

        $entity->setInvitedFlag();

        $this->assertNotNull($entity->invited_at);
    }

    /** @test */
    public function it_can_unset_invited_flag()
    {
        $entity = factory(EntityWithInvitedAt::class)->create([
            'invited_at' => Carbon::now(),
        ]);

        $entity->unsetInvitedFlag();

        $this->assertNull($entity->invited_at);
    }

    /** @test */
    public function it_can_check_if_entity_is_invited()
    {
        $invitedEntity = factory(EntityWithInvitedAt::class)->create([
            'invited_at' => Carbon::now(),
        ]);

        $uninvitedEntity = factory(EntityWithInvitedAt::class)->create([
            'invited_at' => null,
        ]);

        $this->assertTrue($invitedEntity->isInvited());
        $this->assertFalse($uninvitedEntity->isInvited());
    }

    /** @test */
    public function it_can_check_if_entity_is_uninvited()
    {
        $invitedEntity = factory(EntityWithInvitedAt::class)->create([
            'invited_at' => Carbon::now(),
        ]);

        $uninvitedEntity = factory(EntityWithInvitedAt::class)->create([
            'invited_at' => null,
        ]);

        $this->assertFalse($invitedEntity->isUninvited());
        $this->assertTrue($uninvitedEntity->isUninvited());
    }

    /** @test */
    public function it_can_invite_entity()
    {
        $entity = factory(EntityWithInvitedAt::class)->create([
            'invited_at' => null,
        ]);

        $entity->invite();

        $this->assertNotNull($entity->invited_at);
    }

    /** @test */
    public function it_can_uninvite_entity()
    {
        $entity = factory(EntityWithInvitedAt::class)->create([
            'invited_at' => Carbon::now(),
        ]);

        $entity->uninvite();

        $this->assertNull($entity->invited_at);
    }
}
