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

trait HasAcceptedFlagHelpers
{
    public function initializeHasAcceptedFlagHelpers(): void
    {
        $this->casts['is_accepted'] = 'boolean';
    }

    /**
     * If entity is accepted.
     *
     * @return bool
     */
    public function isAccepted(): bool
    {
        return $this->getAttributeValue('is_accepted');
    }

    /**
     * If entity is rejected.
     *
     * @return bool
     */
    public function isRejected(): bool
    {
        return !$this->isAccepted();
    }

    /**
     * Mark entity as accepted.
     *
     * @return void
     */
    public function accept(): void
    {
        $this->setAttribute('is_accepted', true);
        $this->save();

        $this->fireModelEvent('accepted', false);
    }

    /**
     * Mark entity as rejected.
     *
     * @return void
     */
    public function reject(): void
    {
        $this->setAttribute('is_accepted', false);
        $this->save();

        $this->fireModelEvent('rejected', false);
    }
}
