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

use Cog\Flag\Scopes\Inverse\ExpiredFlagScope;

/**
 * Class HasExpiredFlag.
 *
 * @package Cog\Flag\Traits\Classic
 */
trait HasExpiredFlag
{
    /**
     * Boot the HasExpiredFlag trait for a model.
     *
     * @return void
     */
    public static function bootHasExpiredFlag()
    {
        static::addGlobalScope(new ExpiredFlagScope);
    }
}
