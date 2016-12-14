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
use Cog\Flag\Tests\Stubs\Models\EntityWithAcceptedFlag;

/**
 * Class AcceptedFlagScopeTest.
 *
 * @package Cog\Merchant\Tests\Unit\Scopes
 */
class AcceptedFlagScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_accepted()
    {
        factory(EntityWithAcceptedFlag::class, 3)->create([
            'is_accepted' => true,
        ]);
        factory(EntityWithAcceptedFlag::class, 2)->create([
            'is_accepted' => false,
        ]);

        $entities = EntityWithAcceptedFlag::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_unaccepted()
    {
        factory(EntityWithAcceptedFlag::class, 3)->create([
            'is_accepted' => true,
        ]);
        factory(EntityWithAcceptedFlag::class, 2)->create([
            'is_accepted' => false,
        ]);

        $entities = EntityWithAcceptedFlag::withoutUnaccepted()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_unaccepted()
    {
        factory(EntityWithAcceptedFlag::class, 3)->create([
            'is_accepted' => true,
        ]);
        factory(EntityWithAcceptedFlag::class, 2)->create([
            'is_accepted' => false,
        ]);

        $entities = EntityWithAcceptedFlag::withUnaccepted()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_unaccepted()
    {
        factory(EntityWithAcceptedFlag::class, 3)->create([
            'is_accepted' => true,
        ]);
        factory(EntityWithAcceptedFlag::class, 2)->create([
            'is_accepted' => false,
        ]);

        $entities = EntityWithAcceptedFlag::onlyUnaccepted()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_accept_model()
    {
        $model = factory(EntityWithAcceptedFlag::class)->create([
            'is_accepted' => false,
        ]);

        EntityWithAcceptedFlag::where('id', $model->id)->accept();

        $model = EntityWithAcceptedFlag::where('id', $model->id)->first();

        $this->assertTrue($model->is_accepted);
    }

    /** @test */
    public function it_can_unaccept_model()
    {
        $model = factory(EntityWithAcceptedFlag::class)->create([
            'is_accepted' => true,
        ]);

        EntityWithAcceptedFlag::where('id', $model->id)->unaccept();

        $model = EntityWithAcceptedFlag::withUnaccepted()->where('id', $model->id)->first();

        $this->assertFalse($model->is_accepted);
    }
}
