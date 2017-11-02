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
 * Class HasEndedFlagHelpers.
 *
 * @package Cog\Flag\Traits\Inverse
 */
trait HasEndedFlagHelpers
{
    /**
     * Set ended flag.
     *
     * @return static
     */
    public function setEndedFlag()
    {
        $this->is_ended = true;

        return $this;
    }

    /**
     * Unset ended flag.
     *
     * @return static
     */
    public function unsetEndedFlag()
    {
        $this->is_ended = false;

        return $this;
    }

    /**
     * If entity is ended.
     *
     * @return bool
     */
    public function isEnded()
    {
        return (bool) $this->is_ended;
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
     * Mark entity as ended.
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
