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

class EntityWithArchivedFlagUnapplied extends EntityWithArchivedFlag
{
    /**
     * Determine if ArchivedFlagScope should be applied by default.
     *
     * @return bool
     */
    public function shouldApplyArchivedFlagScope()
    {
        return false;
    }
}
