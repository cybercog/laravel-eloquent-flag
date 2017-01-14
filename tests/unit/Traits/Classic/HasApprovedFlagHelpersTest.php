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

use Cog\Flag\Tests\Stubs\Models\Classic\EntityWithApprovedFlag;
use Cog\Flag\Tests\TestCase;

/**
 * Class HasApprovedFlagHelpersTest.
 *
 * @package Cog\Flag\Tests\Unit\Traits\Classic
 */
class HasApprovedFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_can_set_approved_flag()
    {
        $entity = factory(EntityWithApprovedFlag::class, 1)->create([
            'is_approved' => false,
        ]);

        $entity->setApprovedFlag();

        $this->assertTrue($entity->is_approved);
    }

    /** @test */
    public function it_can_unset_approved_flag()
    {
        $entity = factory(EntityWithApprovedFlag::class, 1)->create([
            'is_approved' => true,
        ]);

        $entity->unsetApprovedFlag();

        $this->assertFalse($entity->is_approved);
    }

    /** @test */
    public function it_can_check_if_entity_is_approved()
    {
        $approvedEntity = factory(EntityWithApprovedFlag::class, 1)->create([
            'is_approved' => true,
        ]);

        $disapprovedEntity = factory(EntityWithApprovedFlag::class, 1)->create([
            'is_approved' => false,
        ]);

        $this->assertTrue($approvedEntity->isApproved());
        $this->assertFalse($disapprovedEntity->isApproved());
    }

    /** @test */
    public function it_can_check_if_entity_is_disapproved()
    {
        $approvedEntity = factory(EntityWithApprovedFlag::class, 1)->create([
            'is_approved' => true,
        ]);

        $disapprovedEntity = factory(EntityWithApprovedFlag::class, 1)->create([
            'is_approved' => false,
        ]);

        $this->assertFalse($approvedEntity->isDisapproved());
        $this->assertTrue($disapprovedEntity->isDisapproved());
    }

    /** @test */
    public function it_can_approve_entity()
    {
        $entity = factory(EntityWithApprovedFlag::class, 1)->create([
            'is_approved' => false,
        ]);

        $entity->approve();

        $this->assertTrue($entity->is_approved);
    }

    /** @test */
    public function it_can_disapprove_entity()
    {
        $entity = factory(EntityWithApprovedFlag::class, 1)->create([
            'is_approved' => true,
        ]);

        $entity->disapprove();

        $this->assertFalse($entity->is_approved);
    }
}
