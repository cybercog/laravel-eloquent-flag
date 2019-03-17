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

    public function isVerified(): bool
    {
        return $this->getAttributeValue('is_verified');
    }

    public function isNotVerified(): bool
    {
        return !$this->isVerified();
    }

    public function verify(): void
    {
        $this->setAttribute('is_verified', true);
        $this->save();

        $this->fireModelEvent('verified', false);
    }

    public function unverify(): void
    {
        $this->setAttribute('is_verified', false);
        $this->save();

        $this->fireModelEvent('unverified', false);
    }
}
