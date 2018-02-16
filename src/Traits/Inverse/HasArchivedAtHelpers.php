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

/**
 * Class HasArchivedAtHelpers.
 *
 * @package Cog\Flag\Traits\Inverse
 */
trait HasArchivedAtHelpers
{
    /**
     * Set archived flag.
     *
     * @return static
     */
    public function setArchivedFlag()
    {
        $this->archived_at = Carbon::now();

        return $this;
    }

    /**
     * Unset archived flag.
     *
     * @return static
     */
    public function unsetArchivedFlag()
    {
        $this->archived_at = null;

        return $this;
    }

    /**
     * If entity is archived.
     *
     * @return bool
     */
    public function isArchived()
    {
        return !is_null($this->archived_at);
    }

    /**
     * If entity is opened.
     *
     * @return bool
     */
    public function isUnarchived()
    {
        return !$this->isArchived();
    }

    /**
     * Mark entity as archived.
     *
     * @return void
     */
    public function archive()
    {
        $this->setArchivedFlag()->save();

        // :TODO: Fire an event here
    }

    /**
     * Mark entity as opened.
     *
     * @return void
     */
    public function unarchive()
    {
        $this->unsetArchivedFlag()->save();

        // :TODO: Fire an event here
    }
}
