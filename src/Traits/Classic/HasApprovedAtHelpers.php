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

namespace Cog\Flag\Traits\Classic;

use Illuminate\Support\Facades\Date;

trait HasApprovedAtHelpers
{
    public function initializeHasApprovedAtHelpers(): void
    {
        $this->dates[] = 'approved_at';
    }

    public function isApproved(): bool
    {
        return !is_null($this->getAttributeValue('approved_at'));
    }

    public function isNotApproved(): bool
    {
        return !$this->isApproved();
    }

    public function approve(): void
    {
        $this->setAttribute('approved_at', Date::now());
        $this->save();

        $this->fireModelEvent('approved', false);
    }

    public function undoApprove(): void
    {
        $this->setAttribute('approved_at', null);
        $this->save();

        $this->fireModelEvent('approvedUndone', false);
    }
}
