<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) CyberCog <support@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Traits;

use Carbon\Carbon;
use Cog\Flag\Scopes\KeptFlagScope;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class HasKeptFlag.
 *
 * @package Cog\Flag\Traits
 */
trait HasKeptFlag
{
    /**
     * Boot the has kept flag trait for a model.
     *
     * @return void
     */
    public static function bootHasKeptFlag()
    {
        static::addGlobalScope(new KeptFlagScope);

        static::creating(function ($entity) {
            if (!$entity->is_kept) {
                $entity->is_kept = false;
            }
        });

        static::updating(function ($entity) {
            if (!$entity->is_kept) {
                $entity->is_kept = true;
            }
        });
    }

    /**
     * Determine if the model instance has `is_kept` state.
     *
     * @return bool
     */
    public function isKept()
    {
        return (bool) $this->is_kept;
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
        return $builder->onlyUnkept()
            ->where(static::getCreatedAtColumn(), '<=', Carbon::now()->subHours($hours)->toDateTimeString());
    }
}
