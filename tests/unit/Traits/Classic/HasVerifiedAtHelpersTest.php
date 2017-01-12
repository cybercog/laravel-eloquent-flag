<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Tests\Unit\Traits\Classic;

use Carbon\Carbon;
use Cog\Flag\Tests\Stubs\Models\Classic\EntityWithVerifiedAt;
use Cog\Flag\Tests\TestCase;

/**
 * Class HasVerifiedAtHelpersTest.
 *
 * @package Cog\Flag\Tests\Unit\Traits\Classic
 */
class HasVerifiedAtHelpersTest extends TestCase
{
    /** @test */
    public function it_can_set_verified_flag()
    {
        $entity = factory(EntityWithVerifiedAt::class, 1)->create([
            'verified_at' => null,
        ]);

        $entity->setVerifiedFlag();

        $this->assertNotNull($entity->verified_at);
    }

    /** @test */
    public function it_can_unset_verified_flag()
    {
        $entity = factory(EntityWithVerifiedAt::class, 1)->create([
            'verified_at' => Carbon::now(),
        ]);

        $entity->unsetVerifiedFlag();

        $this->assertNull($entity->verified_at);
    }

    /** @test */
    public function it_can_check_if_entity_is_verified()
    {
        $verifiedEntity = factory(EntityWithVerifiedAt::class, 1)->create([
            'verified_at' => Carbon::now(),
        ]);

        $unverifiedEntity = factory(EntityWithVerifiedAt::class, 1)->create([
            'verified_at' => null,
        ]);

        $this->assertTrue($verifiedEntity->isVerified());
        $this->assertFalse($unverifiedEntity->isVerified());
    }

    /** @test */
    public function it_can_check_if_entity_is_unverified()
    {
        $verifiedEntity = factory(EntityWithVerifiedAt::class, 1)->create([
            'verified_at' => Carbon::now(),
        ]);

        $unverifiedEntity = factory(EntityWithVerifiedAt::class, 1)->create([
            'verified_at' => null,
        ]);

        $this->assertFalse($verifiedEntity->isUnverified());
        $this->assertTrue($unverifiedEntity->isUnverified());
    }

    /** @test */
    public function it_can_verify_entity()
    {
        $entity = factory(EntityWithVerifiedAt::class, 1)->create([
            'verified_at' => null,
        ]);

        $entity->verify();

        $this->assertNotNull($entity->verified_at);
    }

    /** @test */
    public function it_can_unverify_entity()
    {
        $entity = factory(EntityWithVerifiedAt::class, 1)->create([
            'verified_at' => Carbon::now(),
        ]);

        $entity->unverify();

        $this->assertNull($entity->verified_at);
    }
}
