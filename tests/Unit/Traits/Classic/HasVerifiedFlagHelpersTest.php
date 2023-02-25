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

use Cog\Tests\Laravel\Flag\Stubs\Models\Classic\EntityWithVerifiedFlag;
use Cog\Tests\Laravel\Flag\TestCase;

final class HasVerifiedFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_is_verified_to_boolean(): void
    {
        $entity = EntityWithVerifiedFlag::factory()->create([
            'is_verified' => 1,
        ]);

        $this->assertTrue($entity->is_verified);
    }

    /** @test */
    public function it_not_casts_is_verified_to_boolean(): void
    {
        $entity = EntityWithVerifiedFlag::factory()->make([
            'is_verified' => null,
        ]);

        $this->assertNull($entity->is_verified);
    }

    /** @test */
    public function it_can_check_if_entity_is_verified(): void
    {
        $verifiedEntity = EntityWithVerifiedFlag::factory()->create([
            'is_verified' => true,
        ]);

        $unverifiedEntity = EntityWithVerifiedFlag::factory()->create([
            'is_verified' => false,
        ]);

        $this->assertTrue($verifiedEntity->isVerified());
        $this->assertFalse($unverifiedEntity->isVerified());
    }

    /** @test */
    public function it_can_check_if_entity_is_not_verified(): void
    {
        $verifiedEntity = EntityWithVerifiedFlag::factory()->create([
            'is_verified' => true,
        ]);

        $unverifiedEntity = EntityWithVerifiedFlag::factory()->create([
            'is_verified' => false,
        ]);

        $this->assertFalse($verifiedEntity->isNotVerified());
        $this->assertTrue($unverifiedEntity->isNotVerified());
    }

    /** @test */
    public function it_can_verify(): void
    {
        $entity = EntityWithVerifiedFlag::factory()->create([
            'is_verified' => false,
        ]);

        $entity->verify();

        $this->assertTrue($entity->is_verified);
    }

    /** @test */
    public function it_can_undo_verify(): void
    {
        $entity = EntityWithVerifiedFlag::factory()->create([
            'is_verified' => true,
        ]);

        $entity->undoVerify();

        $this->assertFalse($entity->is_verified);
    }
}
