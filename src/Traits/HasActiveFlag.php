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

use Cog\Flag\Scopes\ActiveFlagScope;

/**
 * Class HasActiveFlag.
 *
 * @package Cog\Flag\Traits
 */
trait HasActiveFlag
{
    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootHasActiveFlag()
    {
        static::addGlobalScope(new ActiveFlagScope);
    }
}
