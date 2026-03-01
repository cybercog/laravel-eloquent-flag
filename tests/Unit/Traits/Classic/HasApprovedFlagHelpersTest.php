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

use Cog\Tests\Laravel\Flag\Stubs\Models\Classic\EntityWithApprovedFlag;
use Cog\Tests\Laravel\Flag\TestCase;

final class HasApprovedFlagHelpersTest extends TestCase
{
    public function test_it_casts_is_approved_to_boolean(): void
    {
        $entity = EntityWithApprovedFlag::factory()->create([
            'is_approved' => 1,
        ]);

        $this->assertTrue($entity->is_approved);
    }

    public function test_it_not_casts_is_approved_to_boolean(): void
    {
        $entity = EntityWithApprovedFlag::factory()->make([
            'is_approved' => null,
        ]);

        $this->assertNull($entity->is_approved);
    }

    public function test_it_can_check_if_entity_is_approved(): void
    {
        $approvedEntity = EntityWithApprovedFlag::factory()->create([
            'is_approved' => true,
        ]);

        $disapprovedEntity = EntityWithApprovedFlag::factory()->create([
            'is_approved' => false,
        ]);

        $this->assertTrue($approvedEntity->isApproved());
        $this->assertFalse($disapprovedEntity->isApproved());
    }

    public function test_it_can_check_if_entity_is_not_approved(): void
    {
        $approvedEntity = EntityWithApprovedFlag::factory()->create([
            'is_approved' => true,
        ]);

        $disapprovedEntity = EntityWithApprovedFlag::factory()->create([
            'is_approved' => false,
        ]);

        $this->assertFalse($approvedEntity->isNotApproved());
        $this->assertTrue($disapprovedEntity->isNotApproved());
    }

    public function test_it_can_approve(): void
    {
        $entity = EntityWithApprovedFlag::factory()->create([
            'is_approved' => false,
        ]);

        $entity->approve();

        $this->assertTrue($entity->is_approved);
    }

    public function test_it_can_undo_approve(): void
    {
        $entity = EntityWithApprovedFlag::factory()->create([
            'is_approved' => true,
        ]);

        $entity->undoApprove();

        $this->assertFalse($entity->is_approved);
    }
}
