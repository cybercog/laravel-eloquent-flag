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

use Cog\Flag\Scopes\Classic\AcceptedFlagScope;

/**
 * Class HasAcceptedFlag.
 *
 * @package Cog\Flag\Traits\Classic
 */
trait HasAcceptedFlag
{
    /**
     * Boot the HasAcceptedFlag trait for a model.
     *
     * @return void
     */
    public static function bootHasAcceptedFlag()
    {
        static::addGlobalScope(new AcceptedFlagScope);
    }
}
