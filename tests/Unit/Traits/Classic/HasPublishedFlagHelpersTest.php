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

class HasPublishedFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_can_set_published_flag(): void
    {
        $entity = factory(EntityWithPublishedFlag::class)->create([
            'is_published' => false,
        ]);

        $entity->setPublishedFlag();

        $this->assertTrue($entity->is_published);
    }

    /** @test */
    public function it_can_unset_published_flag(): void
    {
        $entity = factory(EntityWithPublishedFlag::class)->create([
            'is_published' => true,
        ]);

        $entity->unsetPublishedFlag();

        $this->assertFalse($entity->is_published);
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
    public function it_can_check_if_entity_is_unpublished(): void
    {
        $publishedEntity = factory(EntityWithPublishedFlag::class)->create([
            'is_published' => true,
        ]);

        $unpublishedEntity = factory(EntityWithPublishedFlag::class)->create([
            'is_published' => false,
        ]);

        $this->assertFalse($publishedEntity->isUnpublished());
        $this->assertTrue($unpublishedEntity->isUnpublished());
    }

    /** @test */
    public function it_can_publish_entity(): void
    {
        $entity = factory(EntityWithPublishedFlag::class)->create([
            'is_published' => false,
        ]);

        $entity->publish();

        $this->assertTrue($entity->is_published);
    }

    /** @test */
    public function it_can_unpublish_entity(): void
    {
        $entity = factory(EntityWithPublishedFlag::class)->create([
            'is_published' => true,
        ]);

        $entity->unpublish();

        $this->assertFalse($entity->is_published);
    }
}
