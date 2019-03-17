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

trait HasDraftedFlagHelpers
{
    public function initializeHasDraftedFlagHelpers(): void
    {
        $this->casts['is_drafted'] = 'boolean';
    }

    /**
     * If entity is drafted.
     *
     * @return bool
     */
    public function isDrafted(): bool
    {
        return $this->getAttributeValue('is_drafted');
    }

    /**
     * If entity is opened.
     *
     * @return bool
     */
    public function isUndrafted(): bool
    {
        return !$this->isDrafted();
    }

    /**
     * Mark entity as drafted.
     *
     * @return void
     */
    public function draft(): void
    {
        $this->setAttribute('is_drafted', true);
        $this->save();

        $this->fireModelEvent('drafted', false);
    }

    /**
     * Mark entity as opened.
     *
     * @return void
     */
    public function undraft(): void
    {
        $this->setAttribute('is_drafted', false);
        $this->save();

        $this->fireModelEvent('undrafted', false);
    }
}
