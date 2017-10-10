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

/**
 * Class HasApprovedFlag.
 *
 * @package Cog\Flag\Traits\Classic
 */
trait HasApprovedFlag
{
    use HasApprovedFlagHelpers;
    use HasApprovedFlagScope;
}
