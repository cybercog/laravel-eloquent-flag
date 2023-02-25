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

use Cog\Tests\Laravel\Flag\Stubs\Models\Classic\EntityWithAcceptedFlag;
use Cog\Tests\Laravel\Flag\TestCase;

final class HasAcceptedFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_is_accepted_to_boolean(): void
    {
        $entity = EntityWithAcceptedFlag::factory()->create([
            'is_accepted' => 1,
        ]);

        $this->assertTrue($entity->is_accepted);
    }

    /** @test */
    public function it_not_casts_is_accepted_to_boolean(): void
    {
        $entity = EntityWithAcceptedFlag::factory()->make([
            'is_accepted' => null,
        ]);

        $this->assertNull($entity->is_accepted);
    }

    /** @test */
    public function it_can_check_if_entity_is_accepted(): void
    {
        $acceptedEntity = EntityWithAcceptedFlag::factory()->create([
            'is_accepted' => true,
        ]);

        $rejectedEntity = EntityWithAcceptedFlag::factory()->create([
            'is_accepted' => false,
        ]);

        $this->assertTrue($acceptedEntity->isAccepted());
        $this->assertFalse($rejectedEntity->isAccepted());
    }

    /** @test */
    public function it_can_check_if_entity_is_not_accepted(): void
    {
        $acceptedEntity = EntityWithAcceptedFlag::factory()->create([
            'is_accepted' => true,
        ]);

        $rejectedEntity = EntityWithAcceptedFlag::factory()->create([
            'is_accepted' => false,
        ]);

        $this->assertFalse($acceptedEntity->isNotAccepted());
        $this->assertTrue($rejectedEntity->isNotAccepted());
    }

    /** @test */
    public function it_can_accept(): void
    {
        $entity = EntityWithAcceptedFlag::factory()->create([
            'is_accepted' => false,
        ]);

        $entity->accept();

        $this->assertTrue($entity->is_accepted);
    }

    /** @test */
    public function it_can_undo_accept(): void
    {
        $entity = EntityWithAcceptedFlag::factory()->create([
            'is_accepted' => true,
        ]);

        $entity->undoAccept();

        $this->assertFalse($entity->is_accepted);
    }
}
