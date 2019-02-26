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

namespace Cog\Tests\Flag\Unit\Scopes\Inverse;

use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithEndedAt;
use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithEndedAtUnapplied;
use Cog\Tests\Flag\TestCase;
use Illuminate\Support\Carbon;

final class EndedAtScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_not_ended(): void
    {
        factory(EntityWithEndedAt::class, 2)->create([
            'ended_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithEndedAt::class, 3)->create([
            'ended_at' => null,
        ]);

        $entities = EntityWithEndedAt::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_ended(): void
    {
        factory(EntityWithEndedAt::class, 2)->create([
            'ended_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithEndedAt::class, 3)->create([
            'ended_at' => null,
        ]);

        $entities = EntityWithEndedAt::withoutEnded()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_ended(): void
    {
        factory(EntityWithEndedAt::class, 2)->create([
            'ended_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithEndedAt::class, 3)->create([
            'ended_at' => null,
        ]);

        $entities = EntityWithEndedAt::withEnded()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_ended(): void
    {
        factory(EntityWithEndedAt::class, 2)->create([
            'ended_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithEndedAt::class, 3)->create([
            'ended_at' => null,
        ]);

        $entities = EntityWithEndedAt::onlyEnded()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_unend_model(): void
    {
        $model = factory(EntityWithEndedAt::class)->create([
            'ended_at' => Carbon::now()->subDay(),
        ]);

        EntityWithEndedAt::where('id', $model->id)->unend();

        $model = EntityWithEndedAt::where('id', $model->id)->first();

        $this->assertNull($model->ended_at);
    }

    /** @test */
    public function it_can_end_model(): void
    {
        $model = factory(EntityWithEndedAt::class)->create([
            'ended_at' => null,
        ]);

        EntityWithEndedAt::where('id', $model->id)->end();

        $model = EntityWithEndedAt::withEnded()->where('id', $model->id)->first();

        $this->assertNotNull($model->ended_at);
    }

    /** @test */
    public function it_can_skip_apply(): void
    {
        factory(EntityWithEndedAt::class, 3)->create([
            'ended_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithEndedAt::class, 2)->create([
            'ended_at' => null,
        ]);

        $entities = EntityWithEndedAtUnapplied::all();

        $this->assertCount(5, $entities);
    }
}
