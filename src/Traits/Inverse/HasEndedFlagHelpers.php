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

trait HasEndedFlagHelpers
{
    public function initializeHasEndedFlagHelpers(): void
    {
        $this->casts['is_ended'] = 'boolean';
    }

    public function isEnded(): bool
    {
        return $this->getAttributeValue('is_ended');
    }

    public function isNotEnded(): bool
    {
        return !$this->isEnded();
    }

    public function end(): void
    {
        $this->setAttribute('is_ended', true);
        $this->save();

        $this->fireModelEvent('ended', false);
    }

    public function undoEnd(): void
    {
        $this->setAttribute('is_ended', false);
        $this->save();

        $this->fireModelEvent('endedUndone', false);
    }
}
