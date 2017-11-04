<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Traits\Inverse;

use Cog\Flag\Scopes\Inverse\ArchivedFlagScope;

/**
 * Class HasArchivedFlagScope.
 *
 * @package Cog\Flag\Traits\Inverse
 */
trait HasArchivedFlagScope
{
    /**
     * Boot the HasArchivedFlagScope trait for a model.
     *
     * @return void
     */
    public static function bootHasArchivedFlagScope()
    {
        static::addGlobalScope(new ArchivedFlagScope);
    }
}
