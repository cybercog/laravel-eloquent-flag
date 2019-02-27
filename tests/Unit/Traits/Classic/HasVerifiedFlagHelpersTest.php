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

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithVerifiedFlag;
use Cog\Tests\Flag\TestCase;

final class HasVerifiedFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_is_verified_to_boolean(): void
    {
        $entity = factory(EntityWithVerifiedFlag::class)->create([
            'is_verified' => 1,
        ]);

        $this->assertTrue($entity->is_verified);
    }

    /** @test */
    public function it_not_casts_is_verified_to_boolean(): void
    {
        $entity = factory(EntityWithVerifiedFlag::class)->make([
            'is_verified' => null,
        ]);

        $this->assertNull($entity->is_verified);
    }

    /** @test */
    public function it_can_set_verified_flag(): void
    {
        $entity = factory(EntityWithVerifiedFlag::class)->create([
            'is_verified' => false,
        ]);

        $entity->setVerifiedFlag();

        $this->assertTrue($entity->is_verified);
    }

    /** @test */
    public function it_can_unset_verified_flag(): void
    {
        $entity = factory(EntityWithVerifiedFlag::class)->create([
            'is_verified' => true,
        ]);

        $entity->unsetVerifiedFlag();

        $this->assertFalse($entity->is_verified);
    }

    /** @test */
    public function it_can_check_if_entity_is_verified(): void
    {
        $verifiedEntity = factory(EntityWithVerifiedFlag::class)->create([
            'is_verified' => true,
        ]);

        $unverifiedEntity = factory(EntityWithVerifiedFlag::class)->create([
            'is_verified' => false,
        ]);

        $this->assertTrue($verifiedEntity->isVerified());
        $this->assertFalse($unverifiedEntity->isVerified());
    }

    /** @test */
    public function it_can_check_if_entity_is_unverified(): void
    {
        $verifiedEntity = factory(EntityWithVerifiedFlag::class)->create([
            'is_verified' => true,
        ]);

        $unverifiedEntity = factory(EntityWithVerifiedFlag::class)->create([
            'is_verified' => false,
        ]);

        $this->assertFalse($verifiedEntity->isUnverified());
        $this->assertTrue($unverifiedEntity->isUnverified());
    }

    /** @test */
    public function it_can_verify_entity(): void
    {
        $entity = factory(EntityWithVerifiedFlag::class)->create([
            'is_verified' => false,
        ]);

        $entity->verify();

        $this->assertTrue($entity->is_verified);
    }

    /** @test */
    public function it_can_unverify_entity(): void
    {
        $entity = factory(EntityWithVerifiedFlag::class)->create([
            'is_verified' => true,
        ]);

        $entity->unverify();

        $this->assertFalse($entity->is_verified);
    }
}
