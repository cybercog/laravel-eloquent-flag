<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Tests\Unit\Scopes\Classic;

use Carbon\Carbon;
use Cog\Flag\Tests\Stubs\Models\Classic\EntityWithAcceptedAt;
use Cog\Flag\Tests\TestCase;

/**
 * Class AcceptedAtScopeTest.
 *
 * @package Cog\Flag\Tests\Unit\Scopes\Classic
 */
class AcceptedAtScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_accepted()
    {
        factory(EntityWithAcceptedAt::class, 3)->create([
            'accepted_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithAcceptedAt::class, 2)->create([
            'accepted_at' => null,
        ]);

        $entities = EntityWithAcceptedAt::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_only_accepted_in_past()
    {
        factory(EntityWithAcceptedAt::class, 3)->create([
            'accepted_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithAcceptedAt::class, 2)->create([
            'accepted_at' => Carbon::now()->addDay(),
        ]);

        $entities = EntityWithAcceptedAt::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_rejected()
    {
        factory(EntityWithAcceptedAt::class, 3)->create([
            'accepted_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithAcceptedAt::class, 2)->create([
            'accepted_at' => null,
        ]);

        $entities = EntityWithAcceptedAt::withoutRejected()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_rejected()
    {
        factory(EntityWithAcceptedAt::class, 3)->create([
            'accepted_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithAcceptedAt::class, 2)->create([
            'accepted_at' => null,
        ]);

        $entities = EntityWithAcceptedAt::withRejected()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_rejected()
    {
        factory(EntityWithAcceptedAt::class, 3)->create([
            'accepted_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithAcceptedAt::class, 2)->create([
            'accepted_at' => null,
        ]);

        $entities = EntityWithAcceptedAt::onlyRejected()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_accept_model()
    {
        $model = factory(EntityWithAcceptedAt::class)->create([
            'accepted_at' => null,
        ]);

        EntityWithAcceptedAt::where('id', $model->id)->accept();

        $model = EntityWithAcceptedAt::where('id', $model->id)->first();

        $this->assertNotNull($model->accepted_at);
    }

    /** @test */
    public function it_can_reject_model()
    {
        $model = factory(EntityWithAcceptedAt::class)->create([
            'accepted_at' => Carbon::now()->subDay(),
        ]);

        EntityWithAcceptedAt::where('id', $model->id)->reject();

        $model = EntityWithAcceptedAt::withRejected()->where('id', $model->id)->first();

        $this->assertNull($model->accepted_at);
    }
}
