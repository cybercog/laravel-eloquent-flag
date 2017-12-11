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

/**
 * Class HasDraftedFlag.
 *
 * @package Cog\Flag\Traits\Inverse
 */
trait HasDraftedFlag
{
    use HasDraftedFlagHelpers;
    use HasDraftedFlagScope;
}
