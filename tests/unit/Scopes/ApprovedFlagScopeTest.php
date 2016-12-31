<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) CyberCog <support@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Tests\Unit\Scopes;

use Cog\Flag\Tests\TestCase;
use Cog\Flag\Tests\Stubs\Models\EntityWithApprovedFlag;

/**
 * Class ApprovedFlagScopeTest.
 *
 * @package Cog\Flag\Tests\Unit\Scopes
 */
class ApprovedFlagScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_approved()
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
    public function it_can_get_without_unapproved()
    {
        factory(EntityWithApprovedFlag::class, 3)->create([
            'is_approved' => true,
        ]);
        factory(EntityWithApprovedFlag::class, 2)->create([
            'is_approved' => false,
        ]);

        $entities = EntityWithApprovedFlag::withoutUnapproved()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_unapproved()
    {
        factory(EntityWithApprovedFlag::class, 3)->create([
            'is_approved' => true,
        ]);
        factory(EntityWithApprovedFlag::class, 2)->create([
            'is_approved' => false,
        ]);

        $entities = EntityWithApprovedFlag::withUnapproved()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_unapproved()
    {
        factory(EntityWithApprovedFlag::class, 3)->create([
            'is_approved' => true,
        ]);
        factory(EntityWithApprovedFlag::class, 2)->create([
            'is_approved' => false,
        ]);

        $entities = EntityWithApprovedFlag::onlyUnapproved()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_approve_model()
    {
        $model = factory(EntityWithApprovedFlag::class)->create([
            'is_approved' => false,
        ]);

        EntityWithApprovedFlag::where('id', $model->id)->approve();

        $model = EntityWithApprovedFlag::where('id', $model->id)->first();

        $this->assertTrue($model->is_approved);
    }

    /** @test */
    public function it_can_unapprove_model()
    {
        $model = factory(EntityWithApprovedFlag::class)->create([
            'is_approved' => true,
        ]);

        EntityWithApprovedFlag::where('id', $model->id)->unapprove();

        $model = EntityWithApprovedFlag::withUnapproved()->where('id', $model->id)->first();

        $this->assertFalse($model->is_approved);
    }
}
