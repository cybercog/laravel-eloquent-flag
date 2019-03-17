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

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithPublishedAt;
use Cog\Tests\Flag\TestCase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

final class HasPublishedAtHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_published_at_to_datetime(): void
    {
        $entity = factory(EntityWithPublishedAt::class)->create([
            'published_at' => '1986-03-28 00:00:00',
        ]);

        $this->assertInstanceOf(Carbon::class, $entity->published_at);
        $this->assertSame('1986-03-28 00:00:00', $entity->published_at->format('Y-m-d H:i:s'));
    }

    /** @test */
    public function it_can_set_published_flag(): void
    {
        $entity = factory(EntityWithPublishedAt::class)->create([
            'published_at' => null,
        ]);

        $entity->setPublishedFlag();

        $this->assertNotNull($entity->published_at);
    }

    /** @test */
    public function it_can_unset_published_flag(): void
    {
        $entity = factory(EntityWithPublishedAt::class)->create([
            'published_at' => Date::now(),
        ]);

        $entity->unsetPublishedFlag();

        $this->assertNull($entity->published_at);
    }

    /** @test */
    public function it_can_check_if_entity_is_published(): void
    {
        $publishedEntity = factory(EntityWithPublishedAt::class)->create([
            'published_at' => Date::now(),
        ]);

        $unpublishedEntity = factory(EntityWithPublishedAt::class)->create([
            'published_at' => null,
        ]);

        $this->assertTrue($publishedEntity->isPublished());
        $this->assertFalse($unpublishedEntity->isPublished());
    }

    /** @test */
    public function it_can_check_if_entity_is_unpublished(): void
    {
        $publishedEntity = factory(EntityWithPublishedAt::class)->create([
            'published_at' => Date::now(),
        ]);

        $unpublishedEntity = factory(EntityWithPublishedAt::class)->create([
            'published_at' => null,
        ]);

        $this->assertFalse($publishedEntity->isUnpublished());
        $this->assertTrue($unpublishedEntity->isUnpublished());
    }

    /** @test */
    public function it_can_publish_entity(): void
    {
        $entity = factory(EntityWithPublishedAt::class)->create([
            'published_at' => null,
        ]);

        $entity->publish();

        $this->assertNotNull($entity->published_at);
    }

    /** @test */
    public function it_can_unpublish_entity(): void
    {
        $entity = factory(EntityWithPublishedAt::class)->create([
            'published_at' => Date::now(),
        ]);

        $entity->unpublish();

        $this->assertNull($entity->published_at);
    }
}
