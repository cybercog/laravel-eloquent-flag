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

/**
 * Class HasArchivedFlagHelpers.
 *
 * @package Cog\Flag\Traits\Inverse
 */
trait HasArchivedFlagHelpers
{
    /**
     * Set archived flag.
     *
     * @return static
     */
    public function setArchivedFlag()
    {
        $this->is_archived = true;

        return $this;
    }

    /**
     * Unset archived flag.
     *
     * @return static
     */
    public function unsetArchivedFlag()
    {
        $this->is_archived = false;

        return $this;
    }

    /**
     * If entity is archived.
     *
     * @return bool
     */
    public function isArchived()
    {
        return (bool) $this->is_archived;
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
