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

use Cog\Flag\Scopes\Classic\VerifiedAtScope;

/**
 * Class HasVerifiedAtScope.
 *
 * @package Cog\Flag\Traits\Classic
 */
trait HasVerifiedAtScope
{
    /**
     * Boot the HasVerifiedAtScope for a model.
     *
     * @return void
     */
    public static function bootHasVerifiedAtScope()
    {
        static::addGlobalScope(new VerifiedAtScope);
    }
}
