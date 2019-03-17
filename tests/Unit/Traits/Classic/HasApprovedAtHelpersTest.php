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

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithApprovedAt;
use Cog\Tests\Flag\TestCase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

final class HasApprovedAtHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_approved_at_to_datetime(): void
    {
        $entity = factory(EntityWithApprovedAt::class)->create([
            'approved_at' => '1986-03-28 00:00:00',
        ]);

        $this->assertInstanceOf(Carbon::class, $entity->approved_at);
        $this->assertSame('1986-03-28 00:00:00', $entity->approved_at->format('Y-m-d H:i:s'));
    }

    /** @test */
    public function it_can_check_if_entity_is_approved(): void
    {
        $approvedEntity = factory(EntityWithApprovedAt::class)->create([
            'approved_at' => Date::now(),
        ]);

        $disapprovedEntity = factory(EntityWithApprovedAt::class)->create([
            'approved_at' => null,
        ]);

        $this->assertTrue($approvedEntity->isApproved());
        $this->assertFalse($disapprovedEntity->isApproved());
    }

    /** @test */
    public function it_can_check_if_entity_is_not_approved(): void
    {
        $approvedEntity = factory(EntityWithApprovedAt::class)->create([
            'approved_at' => Date::now(),
        ]);

        $disapprovedEntity = factory(EntityWithApprovedAt::class)->create([
            'approved_at' => null,
        ]);

        $this->assertFalse($approvedEntity->isNotApproved());
        $this->assertTrue($disapprovedEntity->isNotApproved());
    }

    /** @test */
    public function it_can_approve_entity(): void
    {
        $entity = factory(EntityWithApprovedAt::class)->create([
            'approved_at' => null,
        ]);

        $entity->approve();

        $this->assertNotNull($entity->approved_at);
    }

    /** @test */
    public function it_can_disapprove_entity(): void
    {
        $entity = factory(EntityWithApprovedAt::class)->create([
            'approved_at' => Date::now(),
        ]);

        $entity->disapprove();

        $this->assertNull($entity->approved_at);
    }
}
