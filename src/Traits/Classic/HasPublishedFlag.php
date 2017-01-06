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

/**
 * Class HasPublishedFlag.
 *
 * @package Cog\Flag\Traits\Classic
 */
trait HasPublishedFlag
{
    use HasPublishedFlagHelpers,
        HasPublishedFlagScope;
}