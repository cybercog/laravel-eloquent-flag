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

trait HasApprovedFlagHelpers
{
    public function initializeHasApprovedFlagHelpers(): void
    {
        $this->casts['is_approved'] = 'boolean';
    }

    /**
     * If entity is approved.
     *
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->getAttributeValue('is_approved');
    }

    /**
     * If entity is disapproved.
     *
     * @return bool
     */
    public function isDisapproved(): bool
    {
        return !$this->isApproved();
    }

    /**
     * Mark entity as approved.
     *
     * @return void
     */
    public function approve(): void
    {
        $this->setAttribute('is_approved', true);
        $this->save();

        $this->fireModelEvent('approved', false);
    }

    /**
     * Mark entity as disapproved.
     *
     * @return void
     */
    public function disapprove(): void
    {
        $this->setAttribute('is_approved', false);
        $this->save();

        $this->fireModelEvent('disapproved', false);
    }
}
