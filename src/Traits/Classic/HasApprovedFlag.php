<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) CyberCog <support@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Traits\Classic;

use Cog\Flag\Scopes\Classic\ApprovedFlagScope;

/**
 * Class HasApprovedFlag.
 *
 * @package Cog\Flag\Traits\Classic
 */
trait HasApprovedFlag
{
    /**
     * Boot the HasApprovedFlag trait for a model.
     *
     * @return void
     */
    public static function bootHasApprovedFlag()
    {
        static::addGlobalScope(new ApprovedFlagScope);
    }
}
