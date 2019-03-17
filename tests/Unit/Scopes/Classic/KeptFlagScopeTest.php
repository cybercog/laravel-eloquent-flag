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

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithKeptFlag;
use Cog\Tests\Flag\TestCase;

final class KeptFlagScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_kept_models(): void
    {
        factory(EntityWithKeptFlag::class, 3)->create([
            'is_kept' => true,
        ]);
        factory(EntityWithKeptFlag::class, 2)->create([
            'is_kept' => false,
        ]);

        $entities = EntityWithKeptFlag::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_not_kept(): void
    {
        factory(EntityWithKeptFlag::class, 3)->create([
            'is_kept' => true,
        ]);
        factory(EntityWithKeptFlag::class, 2)->create([
            'is_kept' => false,
        ]);

        $entities = EntityWithKeptFlag::withoutNotKept()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_not_kept(): void
    {
        factory(EntityWithKeptFlag::class, 3)->create([
            'is_kept' => true,
        ]);
        factory(EntityWithKeptFlag::class, 2)->create([
            'is_kept' => false,
        ]);

        $entities = EntityWithKeptFlag::withNotKept()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_not_kept(): void
    {
        factory(EntityWithKeptFlag::class, 3)->create([
            'is_kept' => true,
        ]);
        factory(EntityWithKeptFlag::class, 2)->create([
            'is_kept' => false,
        ]);

        $entities = EntityWithKeptFlag::onlyNotKept()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_keep_model(): void
    {
        $model = factory(EntityWithKeptFlag::class)->create([
            'is_kept' => false,
        ]);

        EntityWithKeptFlag::where('id', $model->id)->keep();

        $model = EntityWithKeptFlag::where('id', $model->id)->first();

        $this->assertTrue($model->is_kept);
    }

    /** @test */
    public function it_can_undo_keep_model(): void
    {
        $model = factory(EntityWithKeptFlag::class)->create([
            'is_kept' => true,
        ]);

        EntityWithKeptFlag::where('id', $model->id)->undoKeep();

        $model = EntityWithKeptFlag::withNotKept()->where('id', $model->id)->first();

        $this->assertFalse($model->is_kept);
    }
}
