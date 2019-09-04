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

trait HasAcceptedFlagHelpers
{
    public function initializeHasAcceptedFlagHelpers(): void
    {
        $this->casts['is_accepted'] = 'boolean';
    }

    public function isAccepted(): bool
    {
        return $this->getAttributeValue('is_accepted');
    }

    public function isNotAccepted(): bool
    {
        return !$this->isAccepted();
    }

    public function accept(): void
    {
        $this->setAttribute('is_accepted', true);
        $this->save();

        $this->fireModelEvent('accepted', false);
    }

    public function undoAccept(): void
    {
        $this->setAttribute('is_accepted', false);
        $this->save();

        $this->fireModelEvent('acceptedUndone', false);
    }
}
