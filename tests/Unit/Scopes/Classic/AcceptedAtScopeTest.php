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

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithAcceptedAt;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithAcceptedAtApplied;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithAcceptedAtUnapplied;
use Cog\Tests\Flag\TestCase;
use Illuminate\Support\Facades\Date;

final class AcceptedAtScopeTest extends TestCase
{
    /** @test */
    public function it_get_without_global_scope_default(): void
    {
        factory(EntityWithAcceptedAt::class, 3)->create([
            'accepted_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithAcceptedAt::class, 2)->create([
            'accepted_at' => null,
        ]);

        $entities = EntityWithAcceptedAt::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_without_not_accepted(): void
    {
        factory(EntityWithAcceptedAt::class, 3)->create([
            'accepted_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithAcceptedAt::class, 2)->create([
            'accepted_at' => null,
        ]);

        $entities = EntityWithAcceptedAt::withoutNotAccepted()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_not_accepted(): void
    {
        factory(EntityWithAcceptedAt::class, 3)->create([
            'accepted_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithAcceptedAt::class, 2)->create([
            'accepted_at' => null,
        ]);

        $entities = EntityWithAcceptedAt::withNotAccepted()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_not_accepted(): void
    {
        factory(EntityWithAcceptedAt::class, 3)->create([
            'accepted_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithAcceptedAt::class, 2)->create([
            'accepted_at' => null,
        ]);

        $entities = EntityWithAcceptedAt::onlyNotAccepted()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_accept_model(): void
    {
        $model = factory(EntityWithAcceptedAt::class)->create([
            'accepted_at' => null,
        ]);

        EntityWithAcceptedAt::where('id', $model->id)->accept();

        $model = EntityWithAcceptedAt::where('id', $model->id)->first();

        $this->assertNotNull($model->accepted_at);
    }

    /** @test */
    public function it_can_undo_accept(): void
    {
        $model = factory(EntityWithAcceptedAt::class)->create([
            'accepted_at' => Date::now()->subDay(),
        ]);

        EntityWithAcceptedAt::where('id', $model->id)->undoAccept();

        $model = EntityWithAcceptedAt::withNotAccepted()->where('id', $model->id)->first();

        $this->assertNull($model->accepted_at);
    }

    /** @test */
    public function it_can_skip_apply(): void
    {
        factory(EntityWithAcceptedAt::class, 3)->create([
            'accepted_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithAcceptedAt::class, 2)->create([
            'accepted_at' => null,
        ]);

        $entities = EntityWithAcceptedAtUnapplied::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_auto_apply(): void
    {
        factory(EntityWithAcceptedAt::class, 3)->create([
            'accepted_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithAcceptedAt::class, 2)->create([
            'accepted_at' => null,
        ]);

        $entities = EntityWithAcceptedAtApplied::all();

        $this->assertCount(3, $entities);
    }
}
