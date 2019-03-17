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

trait HasInvitedFlagHelpers
{
    public function initializeHasInvitedFlagHelpers(): void
    {
        $this->casts['is_invited'] = 'boolean';
    }

    /**
     * If entity is invited.
     *
     * @return bool
     */
    public function isInvited(): bool
    {
        return $this->getAttributeValue('is_invited');
    }

    /**
     * If entity is uninvited.
     *
     * @return bool
     */
    public function isUninvited(): bool
    {
        return !$this->isInvited();
    }

    /**
     * Mark entity as invited.
     *
     * @return void
     */
    public function invite(): void
    {
        $this->setAttribute('is_invited', true);
        $this->save();

        $this->fireModelEvent('invited', false);
    }

    /**
     * Mark entity as uninvited.
     *
     * @return void
     */
    public function uninvite(): void
    {
        $this->setAttribute('is_invited', false);
        $this->save();

        $this->fireModelEvent('uninvited', false);
    }
}
