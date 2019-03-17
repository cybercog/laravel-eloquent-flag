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

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithActiveFlag;
use Cog\Tests\Flag\TestCase;

final class ActiveFlagScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_active(): void
    {
        factory(EntityWithActiveFlag::class, 3)->create([
            'is_active' => true,
        ]);
        factory(EntityWithActiveFlag::class, 2)->create([
            'is_active' => false,
        ]);

        $entities = EntityWithActiveFlag::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_not_activated(): void
    {
        factory(EntityWithActiveFlag::class, 3)->create([
            'is_active' => true,
        ]);
        factory(EntityWithActiveFlag::class, 2)->create([
            'is_active' => false,
        ]);

        $entities = EntityWithActiveFlag::withoutNotActivated()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_not_activated(): void
    {
        factory(EntityWithActiveFlag::class, 3)->create([
            'is_active' => true,
        ]);
        factory(EntityWithActiveFlag::class, 2)->create([
            'is_active' => false,
        ]);

        $entities = EntityWithActiveFlag::withNotActivated()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_not_activated(): void
    {
        factory(EntityWithActiveFlag::class, 3)->create([
            'is_active' => true,
        ]);
        factory(EntityWithActiveFlag::class, 2)->create([
            'is_active' => false,
        ]);

        $entities = EntityWithActiveFlag::onlyNotActivated()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_activate_model(): void
    {
        $model = factory(EntityWithActiveFlag::class)->create([
            'is_active' => false,
        ]);

        EntityWithActiveFlag::where('id', $model->id)->activate();

        $model = EntityWithActiveFlag::where('id', $model->id)->first();

        $this->assertTrue($model->is_active);
    }

    /** @test */
    public function it_can_undo_activate_model(): void
    {
        $model = factory(EntityWithActiveFlag::class)->create([
            'is_active' => true,
        ]);

        EntityWithActiveFlag::where('id', $model->id)->undoActivate();

        $model = EntityWithActiveFlag::withNotActivated()->where('id', $model->id)->first();

        $this->assertFalse($model->is_active);
    }
}
