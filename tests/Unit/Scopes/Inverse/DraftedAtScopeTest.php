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

use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithDraftedAt;
use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithDraftedAtUnapplied;
use Cog\Tests\Flag\TestCase;
use Illuminate\Support\Facades\Date;

final class DraftedAtScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_not_drafted(): void
    {
        factory(EntityWithDraftedAt::class, 2)->create([
            'drafted_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithDraftedAt::class, 3)->create([
            'drafted_at' => null,
        ]);

        $entities = EntityWithDraftedAt::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_drafted(): void
    {
        factory(EntityWithDraftedAt::class, 2)->create([
            'drafted_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithDraftedAt::class, 3)->create([
            'drafted_at' => null,
        ]);

        $entities = EntityWithDraftedAt::withoutDrafted()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_drafted(): void
    {
        factory(EntityWithDraftedAt::class, 2)->create([
            'drafted_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithDraftedAt::class, 3)->create([
            'drafted_at' => null,
        ]);

        $entities = EntityWithDraftedAt::withDrafted()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_drafted(): void
    {
        factory(EntityWithDraftedAt::class, 2)->create([
            'drafted_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithDraftedAt::class, 3)->create([
            'drafted_at' => null,
        ]);

        $entities = EntityWithDraftedAt::onlyDrafted()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_undraft_model(): void
    {
        $model = factory(EntityWithDraftedAt::class)->create([
            'drafted_at' => Date::now()->subDay(),
        ]);

        EntityWithDraftedAt::where('id', $model->id)->undraft();

        $model = EntityWithDraftedAt::where('id', $model->id)->first();

        $this->assertNull($model->drafted_at);
    }

    /** @test */
    public function it_can_draft_model(): void
    {
        $model = factory(EntityWithDraftedAt::class)->create([
            'drafted_at' => null,
        ]);

        EntityWithDraftedAt::where('id', $model->id)->draft();

        $model = EntityWithDraftedAt::withDrafted()->where('id', $model->id)->first();

        $this->assertNotNull($model->drafted_at);
    }

    /** @test */
    public function it_can_skip_apply(): void
    {
        factory(EntityWithDraftedAt::class, 3)->create([
            'drafted_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithDraftedAt::class, 2)->create([
            'drafted_at' => null,
        ]);

        $entities = EntityWithDraftedAtUnapplied::all();

        $this->assertCount(5, $entities);
    }
}
