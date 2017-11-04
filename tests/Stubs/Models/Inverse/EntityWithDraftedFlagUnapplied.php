<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Tests\Flag\Stubs\Models\Inverse;

/**
 * Class EntityWithDraftedFlagUnapplied.
 *
 * @package Cog\Tests\Flag\Stubs\Models\Inverse
 */
class EntityWithDraftedFlagUnapplied extends EntityWithDraftedFlag
{
    /**
     * Determine if DraftedFlagScope should be applied by default.
     *
     * @return bool
     */
    public function shouldApplyDraftedFlagScope()
    {
        return false;
    }
}
