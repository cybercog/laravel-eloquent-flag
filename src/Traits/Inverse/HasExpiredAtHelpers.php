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

use Carbon\Carbon;

/**
 * Class HasExpiredAtHelpers.
 *
 * @package Cog\Flag\Traits\Inverse
 */
trait HasExpiredAtHelpers
{
    /**
     * Set expired flag.
     *
     * @return static
     */
    public function setExpiredFlag()
    {
        $this->expired_at = Carbon::now();

        return $this;
    }

    /**
     * Unset expired flag.
     *
     * @return static
     */
    public function unsetExpiredFlag()
    {
        $this->expired_at = null;

        return $this;
    }

    /**
     * If entity is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return !is_null($this->expired_at);
    }

    /**
     * If entity is opened.
     *
     * @return bool
     */
    public function isUnexpired()
    {
        return !$this->isExpired();
    }

    /**
     * Mark entity as expired.
     *
     * @return void
     */
    public function expire()
    {
        $this->setExpiredFlag()->save();

        // :TODO: Fire an event here
    }

    /**
     * Mark entity as opened.
     *
     * @return void
     */
    public function unexpire()
    {
        $this->unsetExpiredFlag()->save();

        // :TODO: Fire an event here
    }
}
