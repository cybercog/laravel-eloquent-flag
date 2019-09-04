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

namespace Cog\Tests\Flag\Unit\Traits\Classic;

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithVerifiedAt;
use Cog\Tests\Flag\TestCase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

final class HasVerifiedAtHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_verified_at_to_datetime(): void
    {
        $entity = factory(EntityWithVerifiedAt::class)->create([
            'verified_at' => '1986-03-28 00:00:00',
        ]);

        $this->assertInstanceOf(Carbon::class, $entity->verified_at);
        $this->assertSame('1986-03-28 00:00:00', $entity->verified_at->format('Y-m-d H:i:s'));
    }

    /** @test */
    public function it_can_check_if_entity_is_verified(): void
    {
        $verifiedEntity = factory(EntityWithVerifiedAt::class)->create([
            'verified_at' => Date::now(),
        ]);

        $unverifiedEntity = factory(EntityWithVerifiedAt::class)->create([
            'verified_at' => null,
        ]);

        $this->assertTrue($verifiedEntity->isVerified());
        $this->assertFalse($unverifiedEntity->isVerified());
    }

    /** @test */
    public function it_can_check_if_entity_is_not_verified(): void
    {
        $verifiedEntity = factory(EntityWithVerifiedAt::class)->create([
            'verified_at' => Date::now(),
        ]);

        $unverifiedEntity = factory(EntityWithVerifiedAt::class)->create([
            'verified_at' => null,
        ]);

        $this->assertFalse($verifiedEntity->isNotVerified());
        $this->assertTrue($unverifiedEntity->isNotVerified());
    }

    /** @test */
    public function it_can_verify(): void
    {
        $entity = factory(EntityWithVerifiedAt::class)->create([
            'verified_at' => null,
        ]);

        $entity->verify();

        $this->assertNotNull($entity->verified_at);
    }

    /** @test */
    public function it_can_undo_verify(): void
    {
        $entity = factory(EntityWithVerifiedAt::class)->create([
            'verified_at' => Date::now(),
        ]);

        $entity->undoVerify();

        $this->assertNull($entity->verified_at);
    }
}
