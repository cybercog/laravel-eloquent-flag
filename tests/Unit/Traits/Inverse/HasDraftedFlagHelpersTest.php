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

use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithDraftedFlag;
use Cog\Tests\Flag\TestCase;

class HasDraftedFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_can_set_drafted_flag(): void
    {
        $entity = factory(EntityWithDraftedFlag::class)->create([
            'is_drafted' => false,
        ]);

        $entity->setDraftedFlag();

        $this->assertTrue($entity->is_drafted);
    }

    /** @test */
    public function it_can_unset_drafted_flag(): void
    {
        $entity = factory(EntityWithDraftedFlag::class)->create([
            'is_drafted' => true,
        ]);

        $entity->unsetDraftedFlag();

        $this->assertFalse($entity->is_drafted);
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
