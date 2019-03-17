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

namespace Cog\Tests\Flag\Unit\Traits\Classic;

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithKeptFlag;
use Cog\Tests\Flag\TestCase;
use Illuminate\Support\Facades\Date;

final class HasKeptFlagHelperTest extends TestCase
{
    /** @test */
    public function it_casts_is_kept_to_boolean(): void
    {
        $entity = factory(EntityWithKeptFlag::class)->create([
            'is_kept' => 1,
        ]);

        $this->assertTrue($entity->is_kept);
    }

    /** @test */
    public function it_not_casts_is_kept_to_boolean(): void
    {
        $entity = factory(EntityWithKeptFlag::class)->make([
            'is_kept' => null,
        ]);

        $this->assertNull($entity->is_kept);
    }

    /** @test */
    public function it_can_check_if_entity_is_kept(): void
    {
        $keptEntity = factory(EntityWithKeptFlag::class)->create([
            'is_kept' => true,
        ]);

        $unkeptEntity = factory(EntityWithKeptFlag::class)->create([
            'is_kept' => false,
        ]);

        $this->assertTrue($keptEntity->isKept());
        $this->assertFalse($unkeptEntity->isKept());
    }

    /** @test */
    public function it_can_check_if_entity_is_unkept(): void
    {
        $keptEntity = factory(EntityWithKeptFlag::class)->create([
            'is_kept' => true,
        ]);

        $unkeptEntity = factory(EntityWithKeptFlag::class)->create([
            'is_kept' => false,
        ]);

        $this->assertFalse($keptEntity->isUnkept());
        $this->assertTrue($unkeptEntity->isUnkept());
    }

    /** @test */
    public function it_can_verify_entity(): void
    {
        $entity = factory(EntityWithKeptFlag::class)->create([
            'is_kept' => false,
        ]);

        $entity->keep();

        $this->assertTrue($entity->is_kept);
    }

    /** @test */
    public function it_can_unkeep_entity(): void
    {
        $entity = factory(EntityWithKeptFlag::class)->create([
            'is_kept' => true,
        ]);

        $entity->unkeep();

        $this->assertFalse($entity->is_kept);
    }

    /** @test */
    public function it_can_get_unkept_older_than_hours(): void
    {
        factory(EntityWithKeptFlag::class, 3)->create([
            'is_kept' => true,
            'created_at' => Date::now()->subHours(4)->toDateTimeString(),
        ]);
        factory(EntityWithKeptFlag::class, 2)->create([
            'is_kept' => false,
            'created_at' => Date::now()->subHours(4)->toDateTimeString(),
        ]);
        factory(EntityWithKeptFlag::class, 2)->create([
            'is_kept' => false,
            'created_at' => Date::now()->subHours(2)->toDateTimeString(),
        ]);
        factory(EntityWithKeptFlag::class, 2)->create([
            'is_kept' => false,
        ]);

        $entities = EntityWithKeptFlag::onlyUnkeptOlderThanHours(4)->get();

        $this->assertCount(2, $entities);
    }
}
