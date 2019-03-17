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

trait HasEndedAtHelpers
{
    public function initializeHasEndedAtHelpers(): void
    {
        $this->dates[] = 'ended_at';
    }

    public function isEnded(): bool
    {
        return !is_null($this->getAttributeValue('ended_at'));
    }

    public function isNotEnded(): bool
    {
        return !$this->isEnded();
    }

    public function end(): void
    {
        $this->setAttribute('ended_at', Date::now());
        $this->save();

        $this->fireModelEvent('ended', false);
    }

    public function undoEnd(): void
    {
        $this->setAttribute('ended_at', null);
        $this->save();

        $this->fireModelEvent('endedUndone', false);
    }
}
