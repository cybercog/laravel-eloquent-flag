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

use Cog\Tests\Laravel\Flag\Stubs\Models\Inverse\EntityWithDraftedFlag;
use Cog\Tests\Laravel\Flag\TestCase;

final class HasDraftedFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_is_drafted_to_boolean(): void
    {
        $entity = EntityWithDraftedFlag::factory()->create([
            'is_drafted' => 1,
        ]);

        $this->assertTrue($entity->is_drafted);
    }

    /** @test */
    public function it_not_casts_is_drafted_to_boolean(): void
    {
        $entity = EntityWithDraftedFlag::factory()->make([
            'is_drafted' => null,
        ]);

        $this->assertNull($entity->is_drafted);
    }

    /** @test */
    public function it_can_check_if_entity_is_drafted(): void
    {
        $draftedEntity = EntityWithDraftedFlag::factory()->create([
            'is_drafted' => true,
        ]);

        $undraftedEntity = EntityWithDraftedFlag::factory()->create([
            'is_drafted' => false,
        ]);

        $this->assertTrue($draftedEntity->isDrafted());
        $this->assertFalse($undraftedEntity->isDrafted());
    }

    /** @test */
    public function it_can_check_if_entity_is_not_drafted(): void
    {
        $draftedEntity = EntityWithDraftedFlag::factory()->create([
            'is_drafted' => true,
        ]);

        $undraftedEntity = EntityWithDraftedFlag::factory()->create([
            'is_drafted' => false,
        ]);

        $this->assertFalse($draftedEntity->isNotDrafted());
        $this->assertTrue($undraftedEntity->isNotDrafted());
    }

    /** @test */
    public function it_can_draft(): void
    {
        $entity = EntityWithDraftedFlag::factory()->create([
            'is_drafted' => false,
        ]);

        $entity->draft();

        $this->assertTrue($entity->is_drafted);
    }

    /** @test */
    public function it_can_undo_draft(): void
    {
        $entity = EntityWithDraftedFlag::factory()->create([
            'is_drafted' => true,
        ]);

        $entity->undoDraft();

        $this->assertFalse($entity->is_drafted);
    }
}
