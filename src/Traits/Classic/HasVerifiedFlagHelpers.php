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
 * Class HasVerifiedFlagHelpers.
 *
 * @package Cog\Flag\Traits\Classic
 */
trait HasVerifiedFlagHelpers
{
    /**
     * Set verified flag.
     *
     * @return static
     */
    public function setVerifiedFlag()
    {
        $this->is_verified = true;

        return $this;
    }

    /**
     * Unset verified flag.
     *
     * @return static
     */
    public function unsetVerifiedFlag()
    {
        $this->is_verified = false;

        return $this;
    }

    /**
     * If entity is verified.
     *
     * @return bool
     */
    public function isVerified()
    {
        return (bool) $this->is_verified;
    }

    /**
     * If entity is unverified.
     *
     * @return bool
     */
    public function isUnverified()
    {
        return !$this->isVerified();
    }

    /**
     * Mark entity as verified.
     *
     * @return void
     */
    public function verify()
    {
        $this->setVerifiedFlag()->save();

        // :TODO: Fire an event here
    }

    /**
     * Mark entity as unverified.
     *
     * @return void
     */
    public function unverify()
    {
        $this->unsetVerifiedFlag()->save();

        // :TODO: Fire an event here
    }
}
