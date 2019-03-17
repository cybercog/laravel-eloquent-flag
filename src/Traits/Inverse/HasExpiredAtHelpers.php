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

use Illuminate\Support\Facades\Date;

trait HasExpiredAtHelpers
{
    public function initializeHasExpiredAtHelpers(): void
    {
        $this->dates[] = 'expired_at';
    }

    /**
     * If entity is expired.
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return !is_null($this->getAttributeValue('expired_at'));
    }

    /**
     * If entity is opened.
     *
     * @return bool
     */
    public function isUnexpired(): bool
    {
        return !$this->isExpired();
    }

    /**
     * Mark entity as expired.
     *
     * @return void
     */
    public function expire(): void
    {
        $this->setAttribute('expired_at', Date::now());
        $this->save();

        $this->fireModelEvent('expired', false);
    }

    /**
     * Mark entity as opened.
     *
     * @return void
     */
    public function unexpire(): void
    {
        $this->setAttribute('expired_at', null);
        $this->save();

        $this->fireModelEvent('unexpired', false);
    }
}
