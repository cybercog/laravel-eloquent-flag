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
    /**
     * Set ended flag.
     *
     * @return static
     */
    public function setEndedFlag()
    {
        $this->setAttribute('is_ended', true);

        return $this;
    }

    /**
     * Unset ended flag.
     *
     * @return static
     */
    public function unsetEndedFlag()
    {
        $this->setAttribute('is_ended', false);

        return $this;
    }

    /**
     * If entity is ended.
     *
     * @return bool
     */
    public function isEnded(): bool
    {
        return (bool) $this->getAttributeValue('is_ended');
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
