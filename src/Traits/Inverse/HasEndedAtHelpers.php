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

use Illuminate\Support\Carbon;

trait HasEndedAtHelpers
{
    public function initializeHasEndedAtHelpers(): void
    {
        $this->dates[] = 'ended_at';
    }

    /**
     * Set end flag.
     *
     * @return static
     */
    public function setEndedFlag()
    {
        $this->setAttribute('ended_at', Carbon::now());

        return $this;
    }

    /**
     * Unset end flag.
     *
     * @return static
     */
    public function unsetEndedFlag()
    {
        $this->setAttribute('ended_at', null);

        return $this;
    }

    /**
     * If entity is end.
     *
     * @return bool
     */
    public function isEnded(): bool
    {
        return !is_null($this->getAttributeValue('ended_at'));
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
     * Mark entity as end.
     *
     * @return void
     */
    public function end(): void
    {
        $this->setEndedFlag()->save();

        $this->fireModelEvent('ended', false);
    }

    /**
     * Mark entity as opened.
     *
     * @return void
     */
    public function unend(): void
    {
        $this->unsetEndedFlag()->save();

        $this->fireModelEvent('unended', false);
    }
}
