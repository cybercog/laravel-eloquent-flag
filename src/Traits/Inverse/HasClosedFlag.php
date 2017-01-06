<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) CyberCog <support@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Traits\Inverse;

use Cog\Flag\Scopes\Inverse\ClosedFlagScope;

/**
 * Class HasClosedFlag.
 *
 * @package Cog\Flag\Traits\Inverse
 */
trait HasClosedFlag
{
    /**
     * Boot the HasClosedFlag trait for a model.
     *
     * @return void
     */
    public static function bootHasClosedFlag()
    {
        static::addGlobalScope(new ClosedFlagScope);
    }
}
