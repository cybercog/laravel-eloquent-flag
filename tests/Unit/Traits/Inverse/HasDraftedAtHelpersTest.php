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

use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithDraftedAt;
use Cog\Tests\Flag\TestCase;
use Illuminate\Support\Carbon;

class HasDraftedAtHelpersTest extends TestCase
{
    /** @test */
    public function it_can_set_drafted_flag(): void
    {
        $entity = factory(EntityWithDraftedAt::class)->create([
            'drafted_at' => null,
        ]);

        $entity->setDraftedFlag();

        $this->assertNotNull($entity->drafted_at);
    }

    /** @test */
    public function it_can_unset_drafted_flag(): void
    {
        $entity = factory(EntityWithDraftedAt::class)->create([
            'drafted_at' => Carbon::now(),
        ]);

        $entity->unsetDraftedFlag();

        $this->assertNull($entity->drafted_at);
    }

    /** @test */
    public function it_can_check_if_entity_is_drafted(): void
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
    public function it_can_check_if_entity_is_undrafted(): void
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
    public function it_can_draft_entity(): void
    {
        $entity = factory(EntityWithDraftedAt::class)->create([
            'drafted_at' => null,
        ]);

        $entity->draft();

        $this->assertNotNull($entity->drafted_at);
    }

    /** @test */
    public function it_can_undraft_entity(): void
    {
        $entity = factory(EntityWithDraftedAt::class)->create([
            'drafted_at' => Carbon::now(),
        ]);

        $entity->undraft();

        $this->assertNull($entity->drafted_at);
    }
}
