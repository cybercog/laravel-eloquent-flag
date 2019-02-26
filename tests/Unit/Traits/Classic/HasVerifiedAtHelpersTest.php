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

use Carbon\Carbon;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithVerifiedAt;
use Cog\Tests\Flag\TestCase;

class HasVerifiedAtHelpersTest extends TestCase
{
    /** @test */
    public function it_can_set_verified_flag(): void
    {
        $entity = factory(EntityWithVerifiedAt::class)->create([
            'verified_at' => null,
        ]);

        $entity->setVerifiedFlag();

        $this->assertNotNull($entity->verified_at);
    }

    /** @test */
    public function it_can_unset_verified_flag(): void
    {
        $entity = factory(EntityWithVerifiedAt::class)->create([
            'verified_at' => Carbon::now(),
        ]);

        $entity->unsetVerifiedFlag();

        $this->assertNull($entity->verified_at);
    }

    /** @test */
    public function it_can_check_if_entity_is_verified(): void
    {
        $verifiedEntity = factory(EntityWithVerifiedAt::class)->create([
            'verified_at' => Carbon::now(),
        ]);

        $unverifiedEntity = factory(EntityWithVerifiedAt::class)->create([
            'verified_at' => null,
        ]);

        $this->assertTrue($verifiedEntity->isVerified());
        $this->assertFalse($unverifiedEntity->isVerified());
    }

    /** @test */
    public function it_can_check_if_entity_is_unverified(): void
    {
        $verifiedEntity = factory(EntityWithVerifiedAt::class)->create([
            'verified_at' => Carbon::now(),
        ]);

        $unverifiedEntity = factory(EntityWithVerifiedAt::class)->create([
            'verified_at' => null,
        ]);

        $this->assertFalse($verifiedEntity->isUnverified());
        $this->assertTrue($unverifiedEntity->isUnverified());
    }

    /** @test */
    public function it_can_verify_entity(): void
    {
        $entity = factory(EntityWithVerifiedAt::class)->create([
            'verified_at' => null,
        ]);

        $entity->verify();

        $this->assertNotNull($entity->verified_at);
    }

    /** @test */
    public function it_can_unverify_entity(): void
    {
        $entity = factory(EntityWithVerifiedAt::class)->create([
            'verified_at' => Carbon::now(),
        ]);

        $entity->unverify();

        $this->assertNull($entity->verified_at);
    }
}
