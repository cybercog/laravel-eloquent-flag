<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Traits\Classic;

/**
 * Class HasAcceptedFlagHelpers.
 *
 * @package Cog\Flag\Traits\Classic
 */
trait HasAcceptedFlagHelpers
{
    /**
     * Set accepted flag.
     *
     * @return static
     */
    public function setAcceptedFlag()
    {
        $this->is_accepted = true;

        return $this;
    }

    /**
     * Unset accepted flag.
     *
     * @return static
     */
    public function unsetAcceptedFlag()
    {
        $this->is_accepted = false;

        return $this;
    }

    /**
     * If entity is accepted.
     *
     * @return bool
     */
    public function isAccepted()
    {
        return (bool) $this->is_accepted;
    }

    /**
     * If entity is rejected.
     *
     * @return bool
     */
    public function isRejected()
    {
        return !$this->isAccepted();
    }

    /**
     * Mark entity as accepted.
     *
     * @return void
     */
    public function accept()
    {
        $this->setAcceptedFlag()->save();

        // :TODO: Fire an event here
    }

    /**
     * Mark entity as rejected.
     *
     * @return void
     */
    public function reject()
    {
        $this->unsetAcceptedFlag()->save();

        // :TODO: Fire an event here
    }
}
