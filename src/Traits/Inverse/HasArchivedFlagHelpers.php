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

trait HasArchivedFlagHelpers
{
    public function initializeHasArchivedFlagHelpers(): void
    {
        $this->casts['is_archived'] = 'boolean';
    }

    /**
     * If entity is archived.
     *
     * @return bool
     */
    public function isArchived(): bool
    {
        return $this->getAttributeValue('is_archived');
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
        $this->setAttribute('is_archived', true);
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
        $this->setAttribute('is_archived', false);
        $this->save();

        $this->fireModelEvent('unarchived', false);
    }
}
