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

trait HasDraftedFlagHelpers
{
    public function initializeHasDraftedFlagHelpers(): void
    {
        $this->casts['is_drafted'] = 'boolean';
    }

    public function isDrafted(): bool
    {
        return $this->getAttributeValue('is_drafted');
    }

    public function isNotDrafted(): bool
    {
        return !$this->isDrafted();
    }

    public function draft(): void
    {
        $this->setAttribute('is_drafted', true);
        $this->save();

        $this->fireModelEvent('drafted', false);
    }

    public function undraft(): void
    {
        $this->setAttribute('is_drafted', false);
        $this->save();

        $this->fireModelEvent('undrafted', false);
    }
}
