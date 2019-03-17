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

namespace Cog\Flag\Traits\Classic;

use Illuminate\Support\Facades\Date;

trait HasVerifiedAtHelpers
{
    public function initializeHasVerifiedAtHelpers(): void
    {
        $this->dates[] = 'verified_at';
    }

    public function isVerified(): bool
    {
        return !is_null($this->getAttributeValue('verified_at'));
    }

    public function isNotVerified(): bool
    {
        return !$this->isVerified();
    }

    public function verify(): void
    {
        $this->setAttribute('verified_at', Date::now());
        $this->save();

        $this->fireModelEvent('verified', false);
    }

    public function undoVerify(): void
    {
        $this->setAttribute('verified_at', null);
        $this->save();

        $this->fireModelEvent('verifiedUndone', false);
    }
}
