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

final class HasKeptFlagBehaviorTest extends TestCase
{
    /** @test */
    public function it_sets_is_kept_false_on_create(): void
    {
        $entity = new EntityWithKeptFlag([
            'name' => 'test',
        ]);
        $entity->save();

        $this->assertFalse($entity->is_kept);
    }

    /** @test */
    public function it_sets_is_kept_true_on_any_update(): void
    {
        $entity = factory(EntityWithKeptFlag::class)->create([
            'is_kept' => false,
        ]);

        $entity->update([
            'name' => 'new-name',
        ]);

        $this->assertTrue($entity->is_kept);
    }
}
