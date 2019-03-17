<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Flag\Traits\Inverse;

trait HasExpiredFlagHelpers
{
    public function initializeHasExpiredFlagHelpers(): void
    {
        $this->casts['is_expired'] = 'boolean';
    }

    public function isExpired(): bool
    {
        return $this->getAttributeValue('is_expired');
    }

    public function isNotExpired(): bool
    {
        return !$this->isExpired();
    }

    public function expire(): void
    {
        $this->setAttribute('is_expired', true);
        $this->save();

        $this->fireModelEvent('expired', false);
    }

    public function undoExpire(): void
    {
        $this->setAttribute('is_expired', false);
        $this->save();

        $this->fireModelEvent('expiredUndone', false);
    }
}
