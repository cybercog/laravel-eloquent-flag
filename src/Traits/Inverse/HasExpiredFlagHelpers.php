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

    /**
     * Set expired flag.
     *
     * @return static
     */
    public function setExpiredFlag()
    {
        $this->setAttribute('is_expired', true);

        return $this;
    }

    /**
     * Unset expired flag.
     *
     * @return static
     */
    public function unsetExpiredFlag()
    {
        $this->setAttribute('is_expired', false);

        return $this;
    }

    /**
     * If entity is expired.
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->getAttributeValue('is_expired');
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
        $this->setExpiredFlag()->save();

        $this->fireModelEvent('expired', false);
    }

    /**
     * Mark entity as opened.
     *
     * @return void
     */
    public function unexpire(): void
    {
        $this->unsetExpiredFlag()->save();

        $this->fireModelEvent('unexpired', false);
    }
}
