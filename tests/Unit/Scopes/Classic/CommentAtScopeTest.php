<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Sivan Wolberg <sivan@wolberg.pro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Tests\Flag\Unit\Scopes\Classic;

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithCommentAt;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithCommentAtApplied;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithCommentAtUnapplied;
use Cog\Tests\Flag\TestCase;
use Illuminate\Support\Facades\Date;

final class CommentAtScopeTest extends TestCase
{
    /** @test */
    public function it_get_without_global_scope_default(): void
    {
        factory(EntityWithCommentAt::class, 3)->create([
            'comment_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithCommentAt::class, 2)->create([
            'comment_at' => null,
        ]);

        $entities = EntityWithCommentAt::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_without_not_comment(): void
    {
        factory(EntityWithCommentAt::class, 3)->create([
            'approved_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithCommentAt::class, 2)->create([
            'approved_at' => null,
        ]);

        $entities = EntityWithCommentAt::withoutNotComment()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_not_comment(): void
    {
        factory(EntityWithCommentAt::class, 3)->create([
            'comment_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithCommentAt::class, 2)->create([
            'comment_at' => null,
        ]);

        $entities = EntityWithCommentAt::withNotComment()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_not_comment(): void
    {
        factory(EntityWithApprovedAt::class, 3)->create([
            'comment_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithApprovedAt::class, 2)->create([
            'comment_at' => null,
        ]);

        $entities = EntityWithCommentAt::onlyNotComment()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_comment_model(): void
    {
        $model = factory(EntityWithCommentAt::class)->create([
            'comment_at' => null,
        ]);

        EntityWithApprovedAt::where('id', $model->id)->comment();

        $model = EntityWithApprovedAt::where('id', $model->id)->first();

        $this->assertNotNull($model->comment_at);
    }

    /** @test */
    public function it_can_undo_comment_model(): void
    {
        $model = factory(EntityWithCommentAt::class)->create([
            'comment_at' => Date::now()->subDay(),
        ]);

        EntityWithCommentAt::where('id', $model->id)->undoComment();

        $model = EntityWithCommentAt::withNotComment()->where('id', $model->id)->first();

        $this->assertNull($model->comment_at);
    }

    /** @test */
    public function it_can_skip_apply(): void
    {
        factory(EntityWithCommentAt::class, 3)->create([
            'comment_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithCommentAt::class, 2)->create([
            'comment_at' => null,
        ]);

        $entities = EntityWithCommentAtUnapplied::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_auto_apply(): void
    {
        factory(EntityWithCommentAt::class, 3)->create([
            'comment_at' => Date::now()->subDay(),
        ]);
        factory(EntityWithCommentAt::class, 2)->create([
            'comment_at' => null,
        ]);

        $entities = EntityWithCommentAtApplied::all();

        $this->assertCount(3, $entities);
    }
}
