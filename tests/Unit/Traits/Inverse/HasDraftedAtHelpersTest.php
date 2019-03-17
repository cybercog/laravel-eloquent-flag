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

use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithDraftedAt;
use Cog\Tests\Flag\TestCase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

final class HasDraftedAtHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_drafted_at_to_datetime(): void
    {
        $entity = factory(EntityWithDraftedAt::class)->create([
            'drafted_at' => '1986-03-28 00:00:00',
        ]);

        $this->assertInstanceOf(Carbon::class, $entity->drafted_at);
        $this->assertSame('1986-03-28 00:00:00', $entity->drafted_at->format('Y-m-d H:i:s'));
    }

    /** @test */
    public function it_can_check_if_entity_is_drafted(): void
    {
        $draftedEntity = factory(EntityWithDraftedAt::class)->create([
            'drafted_at' => Date::now(),
        ]);

        $undraftedEntity = factory(EntityWithDraftedAt::class)->create([
            'drafted_at' => null,
        ]);

        $this->assertTrue($draftedEntity->isDrafted());
        $this->assertFalse($undraftedEntity->isDrafted());
    }

    /** @test */
    public function it_can_check_if_entity_is_not_drafted(): void
    {
        $draftedEntity = factory(EntityWithDraftedAt::class)->create([
            'drafted_at' => Date::now(),
        ]);

        $undraftedEntity = factory(EntityWithDraftedAt::class)->create([
            'drafted_at' => null,
        ]);

        $this->assertFalse($draftedEntity->isNotDrafted());
        $this->assertTrue($undraftedEntity->isNotDrafted());
    }

    /** @test */
    public function it_can_draft(): void
    {
        $entity = factory(EntityWithDraftedAt::class)->create([
            'drafted_at' => null,
        ]);

        $entity->draft();

        $this->assertNotNull($entity->drafted_at);
    }

    /** @test */
    public function it_can_undo_draft(): void
    {
        $entity = factory(EntityWithDraftedAt::class)->create([
            'drafted_at' => Date::now(),
        ]);

        $entity->undoDraft();

        $this->assertNull($entity->drafted_at);
    }
}
