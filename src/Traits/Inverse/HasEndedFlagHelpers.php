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

trait HasEndedFlagHelpers
{
    public function initializeHasEndedFlagHelpers(): void
    {
        $this->casts['is_ended'] = 'boolean';
    }

    /**
     * If entity is ended.
     *
     * @return bool
     */
    public function isEnded(): bool
    {
        return $this->getAttributeValue('is_ended');
    }

    /**
     * If entity is opened.
     *
     * @return bool
     */
    public function isUnended(): bool
    {
        return !$this->isEnded();
    }

    /**
     * Mark entity as ended.
     *
     * @return void
     */
    public function end(): void
    {
        $this->setAttribute('is_ended', true);
        $this->save();

        $this->fireModelEvent('ended', false);
    }

    /**
     * Mark entity as opened.
     *
     * @return void
     */
    public function unend(): void
    {
        $this->setAttribute('is_ended', false);
        $this->save();

        $this->fireModelEvent('unended', false);
    }
}
