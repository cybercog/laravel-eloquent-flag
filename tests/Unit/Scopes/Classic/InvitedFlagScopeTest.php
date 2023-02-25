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

namespace Cog\Tests\Laravel\Flag\Unit\Scopes\Classic;

use Cog\Tests\Laravel\Flag\Stubs\Models\Classic\EntityWithInvitedFlag;
use Cog\Tests\Laravel\Flag\Stubs\Models\Classic\EntityWithInvitedFlagApplied;
use Cog\Tests\Laravel\Flag\Stubs\Models\Classic\EntityWithInvitedFlagUnapplied;
use Cog\Tests\Laravel\Flag\TestCase;

final class InvitedFlagScopeTest extends TestCase
{
    /** @test */
    public function it_get_without_global_scope_default(): void
    {
        EntityWithInvitedFlag::factory()->count(3)->create([
            'is_invited' => true,
        ]);
        EntityWithInvitedFlag::factory()->count(2)->create([
            'is_invited' => false,
        ]);

        $entities = EntityWithInvitedFlag::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_without_not_invited(): void
    {
        EntityWithInvitedFlag::factory()->count(3)->create([
            'is_invited' => true,
        ]);
        EntityWithInvitedFlag::factory()->count(2)->create([
            'is_invited' => false,
        ]);

        $entities = EntityWithInvitedFlag::withoutNotInvited()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_not_invited(): void
    {
        EntityWithInvitedFlag::factory()->count(3)->create([
            'is_invited' => true,
        ]);
        EntityWithInvitedFlag::factory()->count(2)->create([
            'is_invited' => false,
        ]);

        $entities = EntityWithInvitedFlag::withNotInvited()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_not_invited(): void
    {
        EntityWithInvitedFlag::factory()->count(3)->create([
            'is_invited' => true,
        ]);
        EntityWithInvitedFlag::factory()->count(2)->create([
            'is_invited' => false,
        ]);

        $entities = EntityWithInvitedFlag::onlyNotInvited()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_invite_model(): void
    {
        $model = EntityWithInvitedFlag::factory()->create([
            'is_invited' => false,
        ]);

        EntityWithInvitedFlag::where('id', $model->id)->invite();

        $model = EntityWithInvitedFlag::where('id', $model->id)->first();

        $this->assertTrue($model->is_invited);
    }

    /** @test */
    public function it_can_undo_invite_model(): void
    {
        $model = EntityWithInvitedFlag::factory()->create([
            'is_invited' => true,
        ]);

        EntityWithInvitedFlag::where('id', $model->id)->undoInvite();

        $model = EntityWithInvitedFlag::withNotInvited()->where('id', $model->id)->first();

        $this->assertFalse($model->is_invited);
    }

    /** @test */
    public function it_can_skip_apply(): void
    {
        EntityWithInvitedFlag::factory()->count(3)->create([
            'is_invited' => true,
        ]);
        EntityWithInvitedFlag::factory()->count(2)->create([
            'is_invited' => false,
        ]);

        $entities = EntityWithInvitedFlagUnapplied::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_auto_apply(): void
    {
        EntityWithInvitedFlag::factory()->count(3)->create([
            'is_invited' => true,
        ]);
        EntityWithInvitedFlag::factory()->count(2)->create([
            'is_invited' => false,
        ]);

        $entities = EntityWithInvitedFlagApplied::all();

        $this->assertCount(3, $entities);
    }
}
