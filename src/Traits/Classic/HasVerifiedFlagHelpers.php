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

namespace Cog\Flag\Traits\Classic;

trait HasVerifiedFlagHelpers
{
    public function initializeHasVerifiedFlagHelpers(): void
    {
        $this->casts['is_verified'] = 'boolean';
    }

    /**
     * If entity is verified.
     *
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->getAttributeValue('is_verified');
    }

    /**
     * If entity is unverified.
     *
     * @return bool
     */
    public function isUnverified(): bool
    {
        return !$this->isVerified();
    }

    /**
     * Mark entity as verified.
     *
     * @return void
     */
    public function verify(): void
    {
        $this->setAttribute('is_verified', true);
        $this->save();

        $this->fireModelEvent('verified', false);
    }

    /**
     * Mark entity as unverified.
     *
     * @return void
     */
    public function unverify(): void
    {
        $this->setAttribute('is_verified', false);
        $this->save();

        $this->fireModelEvent('unverified', false);
    }
}
