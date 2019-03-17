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

use Cog\Flag\Scopes\Classic\KeptFlagScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Date;

trait HasKeptFlagHelpers
{
    public function initializeHasKeptFlagHelpers(): void
    {
        $this->casts['is_kept'] = 'boolean';
    }

    public function isKept(): bool
    {
        return $this->getAttributeValue('is_kept');
    }

    public function isNotKept(): bool
    {
        return !$this->isKept();
    }

    public function keep(): void
    {
        $this->setAttribute('is_kept', true);
        $this->save();

        $this->fireModelEvent('kept', false);
    }

    public function unkeep(): void
    {
        $this->setAttribute('is_kept', false);
        if (property_exists($this, 'setKeptOnUpdate')) {
            $this->setKeptOnUpdate = false;
        }
        $this->save();

        $this->fireModelEvent('unkept', false);
    }

    /**
     * Get unkept models that are older than the given number of hours.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param int $hours
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnlyUnkeptOlderThanHours(Builder $builder, $hours)
    {
        return $builder
            ->withoutGlobalScope(KeptFlagScope::class)
            ->where('is_kept', 0)
            ->where(static::getCreatedAtColumn(), '<=', Date::now()->subHours($hours)->toDateTimeString());
    }
}
