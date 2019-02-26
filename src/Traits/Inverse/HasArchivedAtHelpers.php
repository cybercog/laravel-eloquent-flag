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

trait HasArchivedAtHelpers
{
    /**
     * Set archived flag.
     *
     * @return static
     */
    public function setArchivedFlag()
    {
        $this->setAttribute('archived_at', Carbon::now());

        return $this;
    }

    /**
     * Unset archived flag.
     *
     * @return static
     */
    public function unsetArchivedFlag()
    {
        $this->setAttribute('archived_at', null);

        return $this;
    }

    /**
     * If entity is archived.
     *
     * @return bool
     */
    public function isArchived()
    {
        return !is_null($this->getAttributeValue('archived_at'));
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

        $this->fireModelEvent('archived', false);
    }

    /**
     * Mark entity as opened.
     *
     * @return void
     */
    public function unarchive()
    {
        $this->unsetArchivedFlag()->save();

        $this->fireModelEvent('unarchived', false);
    }
}
