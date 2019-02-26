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

namespace Cog\Tests\Flag\Unit\Scopes\Classic;

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithApprovedFlag;
use Cog\Tests\Flag\TestCase;

class ApprovedFlagScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_approved(): void
    {
        factory(EntityWithApprovedFlag::class, 3)->create([
            'is_approved' => true,
        ]);
        factory(EntityWithApprovedFlag::class, 2)->create([
            'is_approved' => false,
        ]);

        $entities = EntityWithApprovedFlag::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_disapproved(): void
    {
        factory(EntityWithApprovedFlag::class, 3)->create([
            'is_approved' => true,
        ]);
        factory(EntityWithApprovedFlag::class, 2)->create([
            'is_approved' => false,
        ]);

        $entities = EntityWithApprovedFlag::withoutDisapproved()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_disapproved(): void
    {
        factory(EntityWithApprovedFlag::class, 3)->create([
            'is_approved' => true,
        ]);
        factory(EntityWithApprovedFlag::class, 2)->create([
            'is_approved' => false,
        ]);

        $entities = EntityWithApprovedFlag::withDisapproved()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_disapproved(): void
    {
        factory(EntityWithApprovedFlag::class, 3)->create([
            'is_approved' => true,
        ]);
        factory(EntityWithApprovedFlag::class, 2)->create([
            'is_approved' => false,
        ]);

        $entities = EntityWithApprovedFlag::onlyDisapproved()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_approve_model(): void
    {
        $model = factory(EntityWithApprovedFlag::class)->create([
            'is_approved' => false,
        ]);

        EntityWithApprovedFlag::where('id', $model->id)->approve();

        $model = EntityWithApprovedFlag::where('id', $model->id)->first();

        $this->assertTrue($model->is_approved);
    }

    /** @test */
    public function it_can_disapprove_model(): void
    {
        $model = factory(EntityWithApprovedFlag::class)->create([
            'is_approved' => true,
        ]);

        EntityWithApprovedFlag::where('id', $model->id)->disapprove();

        $model = EntityWithApprovedFlag::withDisapproved()->where('id', $model->id)->first();

        $this->assertFalse($model->is_approved);
    }
}
