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

use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithExpiredFlag;
use Cog\Tests\Flag\TestCase;

class HasExpiredFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_can_set_expired_flag()
    {
        $entity = factory(EntityWithExpiredFlag::class)->create([
            'is_expired' => false,
        ]);

        $entity->setExpiredFlag();

        $this->assertTrue($entity->is_expired);
    }

    /** @test */
    public function it_can_unset_expired_flag()
    {
        $entity = factory(EntityWithExpiredFlag::class)->create([
            'is_expired' => true,
        ]);

        $entity->unsetExpiredFlag();

        $this->assertFalse($entity->is_expired);
    }

    /** @test */
    public function it_can_check_if_entity_is_expired()
    {
        $expiredEntity = factory(EntityWithExpiredFlag::class)->create([
            'is_expired' => true,
        ]);

        $unexpiredEntity = factory(EntityWithExpiredFlag::class)->create([
            'is_expired' => false,
        ]);

        $this->assertTrue($expiredEntity->isExpired());
        $this->assertFalse($unexpiredEntity->isExpired());
    }

    /** @test */
    public function it_can_check_if_entity_is_unexpired()
    {
        $expiredEntity = factory(EntityWithExpiredFlag::class)->create([
            'is_expired' => true,
        ]);

        $unexpiredEntity = factory(EntityWithExpiredFlag::class)->create([
            'is_expired' => false,
        ]);

        $this->assertFalse($expiredEntity->isUnexpired());
        $this->assertTrue($unexpiredEntity->isUnexpired());
    }

    /** @test */
    public function it_can_expire_entity()
    {
        $entity = factory(EntityWithExpiredFlag::class)->create([
            'is_expired' => false,
        ]);

        $entity->expire();

        $this->assertTrue($entity->is_expired);
    }

    /** @test */
    public function it_can_unexpire_entity()
    {
        $entity = factory(EntityWithExpiredFlag::class)->create([
            'is_expired' => true,
        ]);

        $entity->unexpire();

        $this->assertFalse($entity->is_expired);
    }
}
