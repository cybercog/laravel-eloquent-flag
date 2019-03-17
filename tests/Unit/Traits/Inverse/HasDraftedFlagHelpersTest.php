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

namespace Cog\Tests\Flag\Unit\Traits\Inverse;

use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithDraftedFlag;
use Cog\Tests\Flag\TestCase;

final class HasDraftedFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_is_drafted_to_boolean(): void
    {
        $entity = factory(EntityWithDraftedFlag::class)->create([
            'is_drafted' => 1,
        ]);

        $this->assertTrue($entity->is_drafted);
    }

    /** @test */
    public function it_not_casts_is_drafted_to_boolean(): void
    {
        $entity = factory(EntityWithDraftedFlag::class)->make([
            'is_drafted' => null,
        ]);

        $this->assertNull($entity->is_drafted);
    }

    /** @test */
    public function it_can_check_if_entity_is_drafted(): void
    {
        $draftedEntity = factory(EntityWithDraftedFlag::class)->create([
            'is_drafted' => true,
        ]);

        $undraftedEntity = factory(EntityWithDraftedFlag::class)->create([
            'is_drafted' => false,
        ]);

        $this->assertTrue($draftedEntity->isDrafted());
        $this->assertFalse($undraftedEntity->isDrafted());
    }

    /** @test */
    public function it_can_check_if_entity_is_undrafted(): void
    {
        $draftedEntity = factory(EntityWithDraftedFlag::class)->create([
            'is_drafted' => true,
        ]);

        $undraftedEntity = factory(EntityWithDraftedFlag::class)->create([
            'is_drafted' => false,
        ]);

        $this->assertFalse($draftedEntity->isUndrafted());
        $this->assertTrue($undraftedEntity->isUndrafted());
    }

    /** @test */
    public function it_can_draft_entity(): void
    {
        $entity = factory(EntityWithDraftedFlag::class)->create([
            'is_drafted' => false,
        ]);

        $entity->draft();

        $this->assertTrue($entity->is_drafted);
    }

    /** @test */
    public function it_can_undraft_entity(): void
    {
        $entity = factory(EntityWithDraftedFlag::class)->create([
            'is_drafted' => true,
        ]);

        $entity->undraft();

        $this->assertFalse($entity->is_drafted);
    }
}
