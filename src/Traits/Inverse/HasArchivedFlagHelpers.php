<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <anton@komarev.com>
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

    public function isArchived(): bool
    {
        return $this->getAttributeValue('is_archived');
    }

    public function isNotArchived(): bool
    {
        return !$this->isArchived();
    }

    public function archive(): void
    {
        $this->setAttribute('is_archived', true);
        $this->save();

        $this->fireModelEvent('archived', false);
    }

    public function undoArchive(): void
    {
        $this->setAttribute('is_archived', false);
        $this->save();

        $this->fireModelEvent('archivedUndone', false);
    }
}
