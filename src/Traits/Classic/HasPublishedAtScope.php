<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Traits\Classic;

use Cog\Flag\Scopes\Classic\PublishedAtScope;

/**
 * Class HasPublishedAtScope.
 *
 * @package Cog\Flag\Traits\Classic
 */
trait HasPublishedAtScope
{
    /**
     * Boot the HasPublishedAtScope trait for a model.
     *
     * @return void
     */
    public static function bootHasPublishedAtScope()
    {
        static::addGlobalScope(new PublishedAtScope);
    }
}
