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
 * Class HasActiveFlagHelpers.
 *
 * @package Cog\Flag\Traits\Classic
 */
trait HasActiveFlagHelpers
{
    /**
     * Set active flag.
     *
     * @return static
     */
    public function setActivatedFlag()
    {
        $this->is_active = true;

        return $this;
    }

    /**
     * Unset active flag.
     *
     * @return static
     */
    public function unsetActivatedFlag()
    {
        $this->is_active = false;

        return $this;
    }

    /**
     * If entity is activated.
     *
     * @return bool
     */
    public function isActivated()
    {
        return (bool) $this->is_active;
    }

    /**
     * If entity is deactivated.
     *
     * @return bool
     */
    public function isDeactivated()
    {
        return !$this->isActivated();
    }

    /**
     * Mark entity as active.
     *
     * @return void
     */
    public function activate()
    {
        $this->setActivatedFlag()->save();

        // :TODO: Fire an event here
    }

    /**
     * Mark entity as deactivated.
     *
     * @return void
     */
    public function deactivate()
    {
        $this->unsetActivatedFlag()->save();

        // :TODO: Fire an event here
    }
}
