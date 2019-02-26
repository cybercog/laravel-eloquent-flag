<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Traits\Inverse;

use Carbon\Carbon;

trait HasEndedAtHelpers
{
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
    public function isEnded()
    {
        return !is_null($this->getAttributeValue('ended_at'));
    }

    /**
     * If entity is opened.
     *
     * @return bool
     */
    public function isUnended()
    {
        return !$this->isEnded();
    }

    /**
     * Mark entity as end.
     *
     * @return void
     */
    public function end()
    {
        $this->setEndedFlag()->save();

        $this->fireModelEvent('ended', false);
    }

    /**
     * Mark entity as opened.
     *
     * @return void
     */
    public function unend()
    {
        $this->unsetEndedFlag()->save();

        $this->fireModelEvent('unended', false);
    }
}
