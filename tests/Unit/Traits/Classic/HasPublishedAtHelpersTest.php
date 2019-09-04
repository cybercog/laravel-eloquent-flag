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
    public function it_can_check_if_entity_is_not_published(): void
    {
        $publishedEntity = factory(EntityWithPublishedAt::class)->create([
            'published_at' => Date::now(),
        ]);

        $unpublishedEntity = factory(EntityWithPublishedAt::class)->create([
            'published_at' => null,
        ]);

        $this->assertFalse($publishedEntity->isNotPublished());
        $this->assertTrue($unpublishedEntity->isNotPublished());
    }

    /** @test */
    public function it_can_publish(): void
    {
        $entity = factory(EntityWithPublishedAt::class)->create([
            'published_at' => null,
        ]);

        $entity->publish();

        $this->assertNotNull($entity->published_at);
    }

    /** @test */
    public function it_can_undo_publish(): void
    {
        $entity = factory(EntityWithPublishedAt::class)->create([
            'published_at' => Date::now(),
        ]);

        $entity->undoPublish();

        $this->assertNull($entity->published_at);
    }
}
