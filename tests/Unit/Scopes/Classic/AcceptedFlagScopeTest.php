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

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithAcceptedFlag;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithAcceptedFlagApplied;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithAcceptedFlagUnapplied;
use Cog\Tests\Flag\TestCase;

final class AcceptedFlagScopeTest extends TestCase
{
    /** @test */
    public function it_get_without_global_scope_default(): void
    {
        factory(EntityWithAcceptedFlag::class, 3)->create([
            'is_accepted' => true,
        ]);
        factory(EntityWithAcceptedFlag::class, 2)->create([
            'is_accepted' => false,
        ]);

        $entities = EntityWithAcceptedFlag::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_without_not_accepted(): void
    {
        factory(EntityWithAcceptedFlag::class, 3)->create([
            'is_accepted' => true,
        ]);
        factory(EntityWithAcceptedFlag::class, 2)->create([
            'is_accepted' => false,
        ]);

        $entities = EntityWithAcceptedFlag::withoutNotAccepted()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_not_accepted(): void
    {
        factory(EntityWithAcceptedFlag::class, 3)->create([
            'is_accepted' => true,
        ]);
        factory(EntityWithAcceptedFlag::class, 2)->create([
            'is_accepted' => false,
        ]);

        $entities = EntityWithAcceptedFlag::withNotAccepted()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_not_accepted(): void
    {
        factory(EntityWithAcceptedFlag::class, 3)->create([
            'is_accepted' => true,
        ]);
        factory(EntityWithAcceptedFlag::class, 2)->create([
            'is_accepted' => false,
        ]);

        $entities = EntityWithAcceptedFlag::onlyNotAccepted()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_accept_model(): void
    {
        $model = factory(EntityWithAcceptedFlag::class)->create([
            'is_accepted' => false,
        ]);

        EntityWithAcceptedFlag::where('id', $model->id)->accept();

        $model = EntityWithAcceptedFlag::where('id', $model->id)->first();

        $this->assertTrue($model->is_accepted);
    }

    /** @test */
    public function it_can_undo_accept_model(): void
    {
        $model = factory(EntityWithAcceptedFlag::class)->create([
            'is_accepted' => true,
        ]);

        EntityWithAcceptedFlag::where('id', $model->id)->undoAccept();

        $model = EntityWithAcceptedFlag::withNotAccepted()->where('id', $model->id)->first();

        $this->assertFalse($model->is_accepted);
    }

    /** @test */
    public function it_can_skip_apply(): void
    {
        factory(EntityWithAcceptedFlag::class, 3)->create([
            'is_accepted' => true,
        ]);
        factory(EntityWithAcceptedFlag::class, 2)->create([
            'is_accepted' => false,
        ]);

        $entities = EntityWithAcceptedFlagUnapplied::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_auto_apply(): void
    {
        factory(EntityWithAcceptedFlag::class, 3)->create([
            'is_accepted' => true,
        ]);
        factory(EntityWithAcceptedFlag::class, 2)->create([
            'is_accepted' => false,
        ]);

        $entities = EntityWithAcceptedFlagApplied::all();

        $this->assertCount(3, $entities);
    }
}
