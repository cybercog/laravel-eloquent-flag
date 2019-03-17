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

trait HasArchivedAtHelpers
{
    public function initializeHasArchivedAtHelpers(): void
    {
        $this->dates[] = 'archived_at';
    }

    /**
     * If entity is archived.
     *
     * @return bool
     */
    public function isArchived(): bool
    {
        return !is_null($this->getAttributeValue('archived_at'));
    }

    /**
     * If entity is opened.
     *
     * @return bool
     */
    public function isUnarchived(): bool
    {
        return !$this->isArchived();
    }

    /**
     * Mark entity as archived.
     *
     * @return void
     */
    public function archive(): void
    {
        $this->setAttribute('archived_at', Date::now());
        $this->save();

        $this->fireModelEvent('archived', false);
    }

    /**
     * Mark entity as opened.
     *
     * @return void
     */
    public function unarchive(): void
    {
        $this->setAttribute('archived_at', null);
        $this->save();

        $this->fireModelEvent('unarchived', false);
    }
}
