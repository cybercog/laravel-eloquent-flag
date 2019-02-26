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

namespace Cog\Flag\Traits\Classic;

use Cog\Flag\Scopes\Classic\PublishedFlagScope;

trait HasPublishedFlagScope
{
    /**
     * Boot the HasPublishedFlagScope trait for a model.
     *
     * @return void
     */
    public static function bootHasPublishedFlagScope(): void
    {
        static::addGlobalScope(new PublishedFlagScope());
    }
}
