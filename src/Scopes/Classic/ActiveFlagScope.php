<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Scopes\Classic;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Class ActiveFlagScope.
 *
 * @package Cog\Flag\Scopes\Classic
 */
class ActiveFlagScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['Activate', 'Deactivate', 'WithDeactivated', 'WithoutDeactivated', 'OnlyDeactivated'];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $builder, Model $model)
    {
        return $builder->where('is_active', 1);
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    /**
     * Add the `activate` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addActivate(Builder $builder)
    {
        $builder->macro('activate', function (Builder $builder) {
            $builder->withDeactivated();

            return $builder->update(['is_active' => 1]);
        });
    }

    /**
     * Add the `deactivate` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addDeactivate(Builder $builder)
    {
        $builder->macro('deactivate', function (Builder $builder) {
            return $builder->update(['is_active' => 0]);
        });
    }

    /**
     * Add the `withDeactivated` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithDeactivated(Builder $builder)
    {
        $builder->macro('withDeactivated', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutDeactivated` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutDeactivated(Builder $builder)
    {
        $builder->macro('withoutDeactivated', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_active', 1);
        });
    }

    /**
     * Add the `onlyDeactivated` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyDeactivated(Builder $builder)
    {
        $builder->macro('onlyDeactivated', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_active', 0);
        });
    }
}
