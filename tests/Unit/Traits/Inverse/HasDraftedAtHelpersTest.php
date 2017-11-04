<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Tests\Flag\Unit\Traits\Classic;

use Carbon\Carbon;
use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithDraftedAt;
use Cog\Tests\Flag\TestCase;

/**
 * Class HasDraftedAtHelpersTest.
 *
 * @package Cog\Tests\Flag\Unit\Traits\Inverse
 */
class HasDraftedAtHelpersTest extends TestCase
{
    /** @test */
    public function it_can_set_drafted_flag()
    {
        $entity = factory(EntityWithDraftedAt::class)->create([
            'drafted_at' => null,
        ]);

        $entity->setDraftedFlag();

        $this->assertNotNull($entity->drafted_at);
    }

    /** @test */
    public function it_can_unset_drafted_flag()
    {
        $entity = factory(EntityWithDraftedAt::class)->create([
            'drafted_at' => Carbon::now(),
        ]);

        $entity->unsetDraftedFlag();

        $this->assertNull($entity->drafted_at);
    }

    /** @test */
    public function it_can_check_if_entity_is_drafted()
    {
        $draftedEntity = factory(EntityWithDraftedAt::class)->create([
            'drafted_at' => Carbon::now(),
        ]);

        $undraftedEntity = factory(EntityWithDraftedAt::class)->create([
            'drafted_at' => null,
        ]);

        $this->assertTrue($draftedEntity->isDrafted());
        $this->assertFalse($undraftedEntity->isDrafted());
    }

    /** @test */
    public function it_can_check_if_entity_is_undrafted()
    {
        $draftedEntity = factory(EntityWithDraftedAt::class)->create([
            'drafted_at' => Carbon::now(),
        ]);

        $undraftedEntity = factory(EntityWithDraftedAt::class)->create([
            'drafted_at' => null,
        ]);

        $this->assertFalse($draftedEntity->isUndrafted());
        $this->assertTrue($undraftedEntity->isUndrafted());
    }

    /** @test */
    public function it_can_draft_entity()
    {
        $entity = factory(EntityWithDraftedAt::class)->create([
            'drafted_at' => null,
        ]);

        $entity->draft();

        $this->assertNotNull($entity->drafted_at);
    }

    /** @test */
    public function it_can_undraft_entity()
    {
        $entity = factory(EntityWithDraftedAt::class)->create([
            'drafted_at' => Carbon::now(),
        ]);

        $entity->undraft();

        $this->assertNull($entity->drafted_at);
    }
}
