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
use Illuminate\Support\Carbon;

trait HasKeptFlagHelpers
{
    public function initializeHasKeptFlagHelpers(): void
    {
        $this->casts['is_kept'] = 'boolean';
    }

    /**
     * Set kept flag.
     *
     * @return static
     */
    public function setKeptFlag()
    {
        $this->setAttribute('is_kept', true);

        return $this;
    }

    /**
     * Unset kept flag.
     *
     * @return static
     */
    public function unsetKeptFlag()
    {
        $this->setAttribute('is_kept', false);

        if (property_exists($this, 'setKeptOnUpdate')) {
            $this->setKeptOnUpdate = false;
        }

        return $this;
    }

    /**
     * If entity is kept.
     *
     * @return bool
     */
    public function isKept(): bool
    {
        return $this->getAttributeValue('is_kept');
    }

    /**
     * If entity is unkept.
     *
     * @return bool
     */
    public function isUnkept(): bool
    {
        return !$this->isKept();
    }

    /**
     * Mark entity as kept.
     *
     * @return void
     */
    public function keep(): void
    {
        $this->setKeptFlag()->save();

        $this->fireModelEvent('kept', false);
    }

    /**
     * Mark entity as unkept.
     *
     * @return void
     */
    public function unkeep(): void
    {
        $this->unsetKeptFlag()->save();

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
            ->where(static::getCreatedAtColumn(), '<=', Carbon::now()->subHours($hours)->toDateTimeString());
    }
}
