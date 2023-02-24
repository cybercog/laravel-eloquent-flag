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

use Illuminate\Support\Facades\Date;

trait HasArchivedAtHelpers
{
    public function initializeHasArchivedAtHelpers(): void
    {
        $this->casts['archived_at'] = 'datetime';
    }

    public function isArchived(): bool
    {
        return !is_null($this->getAttributeValue('archived_at'));
    }

    public function isNotArchived(): bool
    {
        return !$this->isArchived();
    }

    public function archive(): void
    {
        $this->setAttribute('archived_at', Date::now());
        $this->save();

        $this->fireModelEvent('archived', false);
    }

    public function undoArchive(): void
    {
        $this->setAttribute('archived_at', null);
        $this->save();

        $this->fireModelEvent('archivedUndone', false);
    }
}
