<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Traits\Classic;

use Carbon\Carbon;
use Cog\Flag\Scopes\Classic\KeptFlagScope;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class HasKeptFlagHelpers.
 *
 * @package Cog\Flag\Traits\Classic
 */
trait HasKeptFlagHelpers
{
    /**
     * Set kept flag.
     *
     * @return static
     */
    public function setKeptFlag()
    {
        $this->is_kept = true;

        return $this;
    }

    /**
     * Unset kept flag.
     *
     * @return static
     */
    public function unsetKeptFlag()
    {
        $this->is_kept = false;
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
    public function isKept()
    {
        return (bool) $this->is_kept;
    }

    /**
     * If entity is unkept.
     *
     * @return bool
     */
    public function isUnkept()
    {
        return !$this->isKept();
    }

    /**
     * Mark entity as kept.
     *
     * @return void
     */
    public function keep()
    {
        $this->setKeptFlag()->save();

        // :TODO: Fire an event here
    }

    /**
     * Mark entity as unkept.
     *
     * @return void
     */
    public function unkeep()
    {
        $this->unsetKeptFlag()->save();

        // :TODO: Fire an event here
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
