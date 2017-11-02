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
 * Class HasEndedAtHelpers.
 *
 * @package Cog\Flag\Traits\Inverse
 */
trait HasEndedAtHelpers
{
    /**
     * Set end flag.
     *
     * @return static
     */
    public function setEndedFlag()
    {
        $this->ended_at = Carbon::now();

        return $this;
    }

    /**
     * Unset end flag.
     *
     * @return static
     */
    public function unsetEndedFlag()
    {
        $this->ended_at = null;

        return $this;
    }

    /**
     * If entity is end.
     *
     * @return bool
     */
    public function isEnded()
    {
        return !is_null($this->ended_at);
    }

    /**
     * If entity is opened.
     *
     * @return bool
     */
    public function isUnended()
    {
        return !$this->isEnded();
    }

    /**
     * Mark entity as end.
     *
     * @return void
     */
    public function end()
    {
        $this->setEndedFlag()->save();

        // :TODO: Fire an event here
    }

    /**
     * Mark entity as opened.
     *
     * @return void
     */
    public function unend()
    {
        $this->unsetEndedFlag()->save();

        // :TODO: Fire an event here
    }
}
