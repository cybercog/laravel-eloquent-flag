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

namespace Cog\Tests\Laravel\Flag\Unit\Traits\Classic;

use Cog\Tests\Laravel\Flag\Stubs\Models\Classic\EntityWithKeptFlag;
use Cog\Tests\Laravel\Flag\TestCase;
use Illuminate\Support\Facades\Date;

final class HasKeptFlagHelperTest extends TestCase
{
    /** @test */
    public function it_casts_is_kept_to_boolean(): void
    {
        $entity = EntityWithKeptFlag::factory()->create([
            'is_kept' => 1,
        ]);

        $this->assertTrue($entity->is_kept);
    }

    /** @test */
    public function it_not_casts_is_kept_to_boolean(): void
    {
        $entity = EntityWithKeptFlag::factory()->make([
            'is_kept' => null,
        ]);

        $this->assertNull($entity->is_kept);
    }

    /** @test */
    public function it_can_check_if_entity_is_kept(): void
    {
        $keptEntity = EntityWithKeptFlag::factory()->create([
            'is_kept' => true,
        ]);

        $unkeptEntity = EntityWithKeptFlag::factory()->create([
            'is_kept' => false,
        ]);

        $this->assertTrue($keptEntity->isKept());
        $this->assertFalse($unkeptEntity->isKept());
    }

    /** @test */
    public function it_can_check_if_entity_is_not_kept(): void
    {
        $keptEntity = EntityWithKeptFlag::factory()->create([
            'is_kept' => true,
        ]);

        $unkeptEntity = EntityWithKeptFlag::factory()->create([
            'is_kept' => false,
        ]);

        $this->assertFalse($keptEntity->isNotKept());
        $this->assertTrue($unkeptEntity->isNotKept());
    }

    /** @test */
    public function it_can_keep(): void
    {
        $entity = EntityWithKeptFlag::factory()->create([
            'is_kept' => false,
        ]);

        $entity->keep();

        $this->assertTrue($entity->is_kept);
    }

    /** @test */
    public function it_can_undo_keep(): void
    {
        $entity = EntityWithKeptFlag::factory()->create([
            'is_kept' => true,
        ]);

        $entity->undoKeep();

        $this->assertFalse($entity->is_kept);
    }

    /** @test */
    public function it_can_get_unkept_older_than_hours(): void
    {
        EntityWithKeptFlag::factory()->count(3)->create([
            'is_kept' => true,
            'created_at' => Date::now()->subHours(4)->toDateTimeString(),
        ]);
        EntityWithKeptFlag::factory()->count(2)->create([
            'is_kept' => false,
            'created_at' => Date::now()->subHours(4)->toDateTimeString(),
        ]);
        EntityWithKeptFlag::factory()->count(2)->create([
            'is_kept' => false,
            'created_at' => Date::now()->subHours(2)->toDateTimeString(),
        ]);
        EntityWithKeptFlag::factory()->count(2)->create([
            'is_kept' => false,
        ]);

        $entities = EntityWithKeptFlag::onlyUnkeptOlderThanHours(4)->get();

        $this->assertCount(2, $entities);
    }
}
