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

namespace Cog\Flag\Traits\Inverse;

use Illuminate\Support\Facades\Date;

trait HasExpiredAtHelpers
{
    public function initializeHasExpiredAtHelpers(): void
    {
        $this->casts['expired_at'] = 'datetime';
    }

    public function isExpired(): bool
    {
        return !is_null($this->getAttributeValue('expired_at'));
    }

    public function isNotExpired(): bool
    {
        return !$this->isExpired();
    }

    public function expire(): void
    {
        $this->setAttribute('expired_at', Date::now());
        $this->save();

        $this->fireModelEvent('expired', false);
    }

    public function undoExpire(): void
    {
        $this->setAttribute('expired_at', null);
        $this->save();

        $this->fireModelEvent('expiredUndone', false);
    }
}
