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

trait HasDraftedAtHelpers
{
    public function initializeHasDraftedAtHelpers(): void
    {
        $this->dates[] = 'drafted_at';
    }

    public function isDrafted(): bool
    {
        return !is_null($this->getAttributeValue('drafted_at'));
    }

    public function isNotDrafted(): bool
    {
        return !$this->isDrafted();
    }

    public function draft(): void
    {
        $this->setAttribute('drafted_at', Date::now());
        $this->save();

        $this->fireModelEvent('drafted', false);
    }

    public function undoDraft(): void
    {
        $this->setAttribute('drafted_at', null);
        $this->save();

        $this->fireModelEvent('draftedUndone', false);
    }
}
