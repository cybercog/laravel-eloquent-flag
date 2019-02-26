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

use Carbon\Carbon;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithInvitedAt;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithInvitedAtUnapplied;
use Cog\Tests\Flag\TestCase;

class InvitedAtScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_invited()
    {
        factory(EntityWithInvitedAt::class, 3)->create([
            'invited_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithInvitedAt::class, 2)->create([
            'invited_at' => null,
        ]);

        $entities = EntityWithInvitedAt::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_uninvited()
    {
        factory(EntityWithInvitedAt::class, 3)->create([
            'invited_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithInvitedAt::class, 2)->create([
            'invited_at' => null,
        ]);

        $entities = EntityWithInvitedAt::withoutUninvited()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_uninvited()
    {
        factory(EntityWithInvitedAt::class, 3)->create([
            'invited_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithInvitedAt::class, 2)->create([
            'invited_at' => null,
        ]);

        $entities = EntityWithInvitedAt::withUninvited()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_uninvited()
    {
        factory(EntityWithInvitedAt::class, 3)->create([
            'invited_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithInvitedAt::class, 2)->create([
            'invited_at' => null,
        ]);

        $entities = EntityWithInvitedAt::onlyUninvited()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_invite_model()
    {
        $model = factory(EntityWithInvitedAt::class)->create([
            'invited_at' => null,
        ]);

        EntityWithInvitedAt::where('id', $model->id)->invite();

        $model = EntityWithInvitedAt::where('id', $model->id)->first();

        $this->assertNotNull($model->invited_at);
    }

    /** @test */
    public function it_can_uninvite_model()
    {
        $model = factory(EntityWithInvitedAt::class)->create([
            'invited_at' => Carbon::now()->subDay(),
        ]);

        EntityWithInvitedAt::where('id', $model->id)->uninvite();

        $model = EntityWithInvitedAt::withUninvited()->where('id', $model->id)->first();

        $this->assertNull($model->invited_at);
    }

    /** @test */
    public function it_can_skip_apply()
    {
        factory(EntityWithInvitedAt::class, 3)->create([
            'invited_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithInvitedAt::class, 2)->create([
            'invited_at' => null,
        ]);

        $entities = EntityWithInvitedAtUnapplied::all();

        $this->assertCount(5, $entities);
    }
}
