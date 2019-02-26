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

use Carbon\Carbon;

trait HasClosedAtHelpers
{
    /**
     * Set closed flag.
     *
     * @return static
     */
    public function setClosedFlag()
    {
        $this->setAttribute('closed_at', Carbon::now());

        return $this;
    }

    /**
     * Unset closed flag.
     *
     * @return static
     */
    public function unsetClosedFlag()
    {
        $this->setAttribute('closed_at', null);

        return $this;
    }

    /**
     * If entity is closed.
     *
     * @return bool
     */
    public function isClosed(): bool
    {
        return !is_null($this->getAttributeValue('closed_at'));
    }

    /**
     * If entity is opened.
     *
     * @return bool
     */
    public function isOpened(): bool
    {
        return !$this->isClosed();
    }

    /**
     * Mark entity as closed.
     *
     * @return void
     */
    public function close(): void
    {
        $this->setClosedFlag()->save();

        $this->fireModelEvent('closed', false);
    }

    /**
     * Mark entity as opened.
     *
     * @return void
     */
    public function open(): void
    {
        $this->unsetClosedFlag()->save();

        $this->fireModelEvent('opened', false);
    }
}
