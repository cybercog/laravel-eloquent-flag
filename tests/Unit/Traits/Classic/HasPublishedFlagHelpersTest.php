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

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithPublishedFlag;
use Cog\Tests\Flag\TestCase;

final class HasPublishedFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_is_published_to_boolean(): void
    {
        $entity = factory(EntityWithPublishedFlag::class)->create([
            'is_published' => 1,
        ]);

        $this->assertTrue($entity->is_published);
    }

    /** @test */
    public function it_not_casts_is_published_to_boolean(): void
    {
        $entity = factory(EntityWithPublishedFlag::class)->make([
            'is_published' => null,
        ]);

        $this->assertNull($entity->is_published);
    }

    /** @test */
    public function it_can_check_if_entity_is_published(): void
    {
        $publishedEntity = factory(EntityWithPublishedFlag::class)->create([
            'is_published' => true,
        ]);

        $unpublishedEntity = factory(EntityWithPublishedFlag::class)->create([
            'is_published' => false,
        ]);

        $this->assertTrue($publishedEntity->isPublished());
        $this->assertFalse($unpublishedEntity->isPublished());
    }

    /** @test */
    public function it_can_check_if_entity_is_not_published(): void
    {
        $publishedEntity = factory(EntityWithPublishedFlag::class)->create([
            'is_published' => true,
        ]);

        $unpublishedEntity = factory(EntityWithPublishedFlag::class)->create([
            'is_published' => false,
        ]);

        $this->assertFalse($publishedEntity->isNotPublished());
        $this->assertTrue($unpublishedEntity->isNotPublished());
    }

    /** @test */
    public function it_can_publish(): void
    {
        $entity = factory(EntityWithPublishedFlag::class)->create([
            'is_published' => false,
        ]);

        $entity->publish();

        $this->assertTrue($entity->is_published);
    }

    /** @test */
    public function it_can_undo_publish(): void
    {
        $entity = factory(EntityWithPublishedFlag::class)->create([
            'is_published' => true,
        ]);

        $entity->undoPublish();

        $this->assertFalse($entity->is_published);
    }
}
