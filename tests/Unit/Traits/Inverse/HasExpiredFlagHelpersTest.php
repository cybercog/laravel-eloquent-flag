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

namespace Cog\Tests\Laravel\Flag\Unit\Traits\Inverse;

use Cog\Tests\Laravel\Flag\Stubs\Models\Inverse\EntityWithExpiredFlag;
use Cog\Tests\Laravel\Flag\TestCase;

final class HasExpiredFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_is_expired_to_boolean(): void
    {
        $entity = factory(EntityWithExpiredFlag::class)->create([
            'is_expired' => 1,
        ]);

        $this->assertTrue($entity->is_expired);
    }

    /** @test */
    public function it_not_casts_is_expired_to_boolean(): void
    {
        $entity = factory(EntityWithExpiredFlag::class)->make([
            'is_expired' => null,
        ]);

        $this->assertNull($entity->is_expired);
    }

    /** @test */
    public function it_can_check_if_entity_is_expired(): void
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
    public function it_can_check_if_entity_is_not_expired(): void
    {
        $expiredEntity = factory(EntityWithExpiredFlag::class)->create([
            'is_expired' => true,
        ]);

        $unexpiredEntity = factory(EntityWithExpiredFlag::class)->create([
            'is_expired' => false,
        ]);

        $this->assertFalse($expiredEntity->isNotExpired());
        $this->assertTrue($unexpiredEntity->isNotExpired());
    }

    /** @test */
    public function it_can_expire(): void
    {
        $entity = factory(EntityWithExpiredFlag::class)->create([
            'is_expired' => false,
        ]);

        $entity->expire();

        $this->assertTrue($entity->is_expired);
    }

    /** @test */
    public function it_can_undo_expire(): void
    {
        $entity = factory(EntityWithExpiredFlag::class)->create([
            'is_expired' => true,
        ]);

        $entity->undoExpire();

        $this->assertFalse($entity->is_expired);
    }
}
