<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Tests\Flag\Unit\Scopes\Classic;

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithAcceptedFlag;
use Cog\Tests\Flag\TestCase;

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
    public function it_can_get_without_rejected()
    {
        factory(EntityWithAcceptedFlag::class, 3)->create([
            'is_accepted' => true,
        ]);
        factory(EntityWithAcceptedFlag::class, 2)->create([
            'is_accepted' => false,
        ]);

        $entities = EntityWithAcceptedFlag::withoutRejected()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_rejected()
    {
        factory(EntityWithAcceptedFlag::class, 3)->create([
            'is_accepted' => true,
        ]);
        factory(EntityWithAcceptedFlag::class, 2)->create([
            'is_accepted' => false,
        ]);

        $entities = EntityWithAcceptedFlag::withRejected()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_rejected()
    {
        factory(EntityWithAcceptedFlag::class, 3)->create([
            'is_accepted' => true,
        ]);
        factory(EntityWithAcceptedFlag::class, 2)->create([
            'is_accepted' => false,
        ]);

        $entities = EntityWithAcceptedFlag::onlyRejected()->get();

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
    public function it_can_reject_model()
    {
        $model = factory(EntityWithAcceptedFlag::class)->create([
            'is_accepted' => true,
        ]);

        EntityWithAcceptedFlag::where('id', $model->id)->reject();

        $model = EntityWithAcceptedFlag::withRejected()->where('id', $model->id)->first();

        $this->assertFalse($model->is_accepted);
    }
}
