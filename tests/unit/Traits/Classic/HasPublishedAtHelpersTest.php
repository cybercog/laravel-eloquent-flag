<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Tests\Unit\Traits\Classic;

use Carbon\Carbon;
use Cog\Flag\Tests\Stubs\Models\Classic\EntityWithPublishedAt;
use Cog\Flag\Tests\TestCase;

/**
 * Class HasPublishedAtHelpersTest.
 *
 * @package Cog\Flag\Tests\Unit\Traits\Classic
 */
class HasPublishedAtHelpersTest extends TestCase
{
    /** @test */
    public function it_can_set_published_flag()
    {
        $entity = factory(EntityWithPublishedAt::class)->create([
            'published_at' => null,
        ]);

        $entity->setPublishedFlag();

        $this->assertNotNull($entity->published_at);
    }

    /** @test */
    public function it_can_unset_published_flag()
    {
        $entity = factory(EntityWithPublishedAt::class)->create([
            'published_at' => Carbon::now(),
        ]);

        $entity->unsetPublishedFlag();

        $this->assertNull($entity->published_at);
    }

    /** @test */
    public function it_can_check_if_entity_is_published()
    {
        $publishedEntity = factory(EntityWithPublishedAt::class)->create([
            'published_at' => Carbon::now(),
        ]);

        $unpublishedEntity = factory(EntityWithPublishedAt::class)->create([
            'published_at' => null,
        ]);

        $this->assertTrue($publishedEntity->isPublished());
        $this->assertFalse($unpublishedEntity->isPublished());
    }

    /** @test */
    public function it_can_check_if_entity_is_unpublished()
    {
        $publishedEntity = factory(EntityWithPublishedAt::class)->create([
            'published_at' => Carbon::now(),
        ]);

        $unpublishedEntity = factory(EntityWithPublishedAt::class)->create([
            'published_at' => null,
        ]);

        $this->assertFalse($publishedEntity->isUnpublished());
        $this->assertTrue($unpublishedEntity->isUnpublished());
    }

    /** @test */
    public function it_can_publish_entity()
    {
        $entity = factory(EntityWithPublishedAt::class)->create([
            'published_at' => null,
        ]);

        $entity->publish();

        $this->assertNotNull($entity->published_at);
    }

    /** @test */
    public function it_can_unpublish_entity()
    {
        $entity = factory(EntityWithPublishedAt::class)->create([
            'published_at' => Carbon::now(),
        ]);

        $entity->unpublish();

        $this->assertNull($entity->published_at);
    }
}
