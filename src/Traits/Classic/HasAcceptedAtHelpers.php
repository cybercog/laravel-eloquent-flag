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

use Illuminate\Support\Carbon;

trait HasAcceptedAtHelpers
{
    public function initializeHasAcceptedAtHelpers(): void
    {
        $this->dates[] = 'accepted_at';
    }

    /**
     * Set accepted flag.
     *
     * @return static
     */
    public function setAcceptedFlag()
    {
        $this->setAttribute('accepted_at', Carbon::now());

        return $this;
    }

    /**
     * Unset accepted flag.
     *
     * @return static
     */
    public function unsetAcceptedFlag()
    {
        $this->setAttribute('accepted_at', null);

        return $this;
    }

    /**
     * If entity is accepted.
     *
     * @return bool
     */
    public function isAccepted(): bool
    {
        return !is_null($this->getAttributeValue('accepted_at'));
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
        $this->setAcceptedFlag()->save();

        $this->fireModelEvent('accepted', false);
    }

    /**
     * Mark entity as rejected.
     *
     * @return void
     */
    public function reject(): void
    {
        $this->unsetAcceptedFlag()->save();

        $this->fireModelEvent('rejected', false);
    }
}
