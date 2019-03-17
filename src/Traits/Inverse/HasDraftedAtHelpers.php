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

use Illuminate\Support\Facades\Date;

trait HasDraftedAtHelpers
{
    public function initializeHasDraftedAtHelpers(): void
    {
        $this->dates[] = 'drafted_at';
    }

    /**
     * If entity is drafted.
     *
     * @return bool
     */
    public function isDrafted(): bool
    {
        return !is_null($this->getAttributeValue('drafted_at'));
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
        $this->setAttribute('drafted_at', Date::now());
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
        $this->setAttribute('drafted_at', null);
        $this->save();

        $this->fireModelEvent('undrafted', false);
    }
}
