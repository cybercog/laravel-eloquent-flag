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

use Cog\Flag\Scopes\VerifiedFlagScope;

/**
 * Class HasVerifiedFlag.
 *
 * @package Cog\Flag\Traits
 */
trait HasVerifiedFlag
{
    /**
     * Boot the HasVerifiedTrait for a model.
     *
     * @return void
     */
    public static function bootHasVerifiedFlag()
    {
        static::addGlobalScope(new VerifiedFlagScope);
    }
}
