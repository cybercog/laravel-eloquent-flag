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

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithApprovedFlag;
use Cog\Tests\Flag\TestCase;

final class HasApprovedFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_is_approved_to_boolean(): void
    {
        $entity = factory(EntityWithApprovedFlag::class)->create([
            'is_approved' => 1,
        ]);

        $this->assertTrue($entity->is_approved);
    }

    /** @test */
    public function it_not_casts_is_approved_to_boolean(): void
    {
        $entity = factory(EntityWithApprovedFlag::class)->make([
            'is_approved' => null,
        ]);

        $this->assertNull($entity->is_approved);
    }

    /** @test */
    public function it_can_check_if_entity_is_approved(): void
    {
        $approvedEntity = factory(EntityWithApprovedFlag::class)->create([
            'is_approved' => true,
        ]);

        $disapprovedEntity = factory(EntityWithApprovedFlag::class)->create([
            'is_approved' => false,
        ]);

        $this->assertTrue($approvedEntity->isApproved());
        $this->assertFalse($disapprovedEntity->isApproved());
    }

    /** @test */
    public function it_can_check_if_entity_is_not_approved(): void
    {
        $approvedEntity = factory(EntityWithApprovedFlag::class)->create([
            'is_approved' => true,
        ]);

        $disapprovedEntity = factory(EntityWithApprovedFlag::class)->create([
            'is_approved' => false,
        ]);

        $this->assertFalse($approvedEntity->isNotApproved());
        $this->assertTrue($disapprovedEntity->isNotApproved());
    }

    /** @test */
    public function it_can_approve(): void
    {
        $entity = factory(EntityWithApprovedFlag::class)->create([
            'is_approved' => false,
        ]);

        $entity->approve();

        $this->assertTrue($entity->is_approved);
    }

    /** @test */
    public function it_can_undo_approve(): void
    {
        $entity = factory(EntityWithApprovedFlag::class)->create([
            'is_approved' => true,
        ]);

        $entity->undoApprove();

        $this->assertFalse($entity->is_approved);
    }
}
