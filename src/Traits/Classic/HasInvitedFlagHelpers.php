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
 * Class HasInvitedFlagHelpers.
 *
 * @package Cog\Flag\Traits\Classic
 */
trait HasInvitedFlagHelpers
{
    /**
     * Set invited flag.
     *
     * @return static
     */
    public function setInvitedFlag()
    {
        $this->is_invited = true;

        return $this;
    }

    /**
     * Unset invited flag.
     *
     * @return static
     */
    public function unsetInvitedFlag()
    {
        $this->is_invited = false;

        return $this;
    }

    /**
     * If entity is invited.
     *
     * @return bool
     */
    public function isInvited()
    {
        return (bool) $this->is_invited;
    }

    /**
     * If entity is uninvited.
     *
     * @return bool
     */
    public function isUninvited()
    {
        return !$this->isInvited();
    }

    /**
     * Mark entity as invited.
     *
     * @return void
     */
    public function invite()
    {
        $this->setInvitedFlag()->save();

        // :TODO: Fire an event here
    }

    /**
     * Mark entity as uninvited.
     *
     * @return void
     */
    public function uninvite()
    {
        $this->unsetInvitedFlag()->save();

        // :TODO: Fire an event here
    }
}
