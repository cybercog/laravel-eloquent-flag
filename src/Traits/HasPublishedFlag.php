<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) CyberCog <support@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Traits;

use Cog\Flag\Scopes\PublishedFlagScope;

/**
 * Class HasPublishedFlag.
 *
 * @package Cog\Flag\Traits
 */
trait HasPublishedFlag
{
    /**
     * Boot the has published flag trait for a model.
     *
     * @return void
     */
    public static function bootHasPublishedFlag()
    {
        static::addGlobalScope(new PublishedFlagScope);
    }
}
