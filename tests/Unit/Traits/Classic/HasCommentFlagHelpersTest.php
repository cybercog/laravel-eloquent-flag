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

namespace Cog\Tests\Flag\Unit\Traits\Classic;

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithCommentFlag;
use Cog\Tests\Flag\TestCase;

final class HasCommentFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_is_commentable_to_boolean(): void
    {
        $entity = factory(EntityWithCommentFlag::class)->create([
            'is_commentable' => 1,
        ]);

        $this->assertTrue($entity->is_commentable);
    }

    /** @test */
    public function it_not_casts_is_commentable_to_boolean(): void
    {
        $entity = factory(EntityWithCommentFlag::class)->make([
            'is_commentable' => null,
        ]);

        $this->assertNull($entity->is_commentable);
    }

    /** @test */
    public function it_can_check_if_entity_is_commentable(): void
    {
        $approvedEntity = factory(EntityWithCommentFlag::class)->create([
            'is_commentable' => true,
        ]);

        $disapprovedEntity = factory(EntityWithCommentFlag::class)->create([
            'is_commentable' => false,
        ]);

        $this->assertTrue($approvedEntity->isComment());
        $this->assertFalse($disapprovedEntity->isComment());
    }

    /** @test */
    public function it_can_check_if_entity_is_not_comment(): void
    {
        $approvedEntity = factory(EntityWithCommentFlag::class)->create([
            'is_commentable' => true,
        ]);

        $disapprovedEntity = factory(EntityWithCommentFlag::class)->create([
            'is_commentable' => false,
        ]);

        $this->assertFalse($approvedEntity->isNotComment());
        $this->assertTrue($disapprovedEntity->isNotComment());
    }

    /** @test */
    public function it_can_comment(): void
    {
        $entity = factory(EntityWithCommentFlag::class)->create([
            'is_commentable' => false,
        ]);

        $entity->comment();

        $this->assertTrue($entity->is_commentable);
    }

    /** @test */
    public function it_can_undo_comment(): void
    {
        $entity = factory(EntityWithCommentFlag::class)->create([
            'is_commentable' => true,
        ]);

        $entity->undoComment();

        $this->assertFalse($entity->is_commentable);
    }
}
