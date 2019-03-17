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

trait HasClosedFlagHelpers
{
    public function initializeHasClosedFlagHelpers(): void
    {
        $this->casts['is_closed'] = 'boolean';
    }

    public function isClosed(): bool
    {
        return $this->getAttributeValue('is_closed');
    }

    public function isNotClosed(): bool
    {
        return !$this->isClosed();
    }

    public function close(): void
    {
        $this->setAttribute('is_closed', true);
        $this->save();

        $this->fireModelEvent('closed', false);
    }

    public function undoClose(): void
    {
        $this->setAttribute('is_closed', false);
        $this->save();

        $this->fireModelEvent('closedUndone', false);
    }
}
