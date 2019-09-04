<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <anton@komarev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Tests\Flag\Unit\Scopes\Classic;

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithInvitedAt;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithInvitedAtApplied;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithInvitedAtUnapplied;
use Cog\Tests\Flag\TestCase;
use Illuminate\Support\Facades\Date;

final class InvitedAtScopeTest extends TestCase
{
    /** @test */
    public function it_get_without_global_scope_default(): void
    {
        factory(EntityWithInvitedAt::class, 3)->create([
            'invited_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithInvitedAt::class, 2)->create([
            'invited_at' => null,
        ]);

        $entities = EntityWithInvitedAt::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_without_not_invited(): void
    {
        factory(EntityWithInvitedAt::class, 3)->create([
            'invited_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithInvitedAt::class, 2)->create([
            'invited_at' => null,
        ]);

        $entities = EntityWithInvitedAt::withoutNotInvited()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_not_invited(): void
    {
        factory(EntityWithInvitedAt::class, 3)->create([
            'invited_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithInvitedAt::class, 2)->create([
            'invited_at' => null,
        ]);

        $entities = EntityWithInvitedAt::withNotInvited()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_not_invited(): void
    {
        factory(EntityWithInvitedAt::class, 3)->create([
            'invited_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithInvitedAt::class, 2)->create([
            'invited_at' => null,
        ]);

        $entities = EntityWithInvitedAt::onlyNotInvited()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_invite_model(): void
    {
        $model = factory(EntityWithInvitedAt::class)->create([
            'invited_at' => null,
        ]);

        EntityWithInvitedAt::where('id', $model->id)->invite();

        $model = EntityWithInvitedAt::where('id', $model->id)->first();

        $this->assertNotNull($model->invited_at);
    }

    /** @test */
    public function it_can_undo_invite_model(): void
    {
        $model = factory(EntityWithInvitedAt::class)->create([
            'invited_at' => Date::now()->subDay(),
        ]);

        EntityWithInvitedAt::where('id', $model->id)->undoInvite();

        $model = EntityWithInvitedAt::withNotInvited()->where('id', $model->id)->first();

        $this->assertNull($model->invited_at);
    }

    /** @test */
    public function it_can_skip_apply(): void
    {
        factory(EntityWithInvitedAt::class, 3)->create([
            'invited_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithInvitedAt::class, 2)->create([
            'invited_at' => null,
        ]);

        $entities = EntityWithInvitedAtUnapplied::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_auto_apply(): void
    {
        factory(EntityWithInvitedAt::class, 3)->create([
            'invited_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithInvitedAt::class, 2)->create([
            'invited_at' => null,
        ]);

        $entities = EntityWithInvitedAtApplied::all();

        $this->assertCount(3, $entities);
    }
}
