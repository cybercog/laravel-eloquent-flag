<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <anton@komarev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Flag\Traits\Classic;

trait HasInvitedFlagHelpers
{
    public function initializeHasInvitedFlagHelpers(): void
    {
        $this->casts['is_invited'] = 'boolean';
    }

    public function isInvited(): bool
    {
        return $this->getAttributeValue('is_invited');
    }

    public function isNotInvited(): bool
    {
        return !$this->isInvited();
    }

    public function invite(): void
    {
        $this->setAttribute('is_invited', true);
        $this->save();

        $this->fireModelEvent('invited', false);
    }

    public function undoInvite(): void
    {
        $this->setAttribute('is_invited', false);
        $this->save();

        $this->fireModelEvent('invitedUndone', false);
    }
}
