<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) CyberCog <support@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ActiveFlagScope.
 *
 * @package Cog\Flag\Scopes
 */
class ActiveFlagScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['Activate', 'Deactivate', 'WithInactive', 'WithoutInactive', 'OnlyInactive'];

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
     * Add the activate extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addActivate(Builder $builder)
    {
        $builder->macro('activate', function (Builder $builder) {
            $builder->withInactive();

            return $builder->update(['is_active' => 1]);
        });
    }

    /**
     * Add the deactivate extension to the builder.
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
     * Add the with-inactive extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addWithInactive(Builder $builder)
    {
        $builder->macro('withInactive', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the without-inactive extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addWithoutInactive(Builder $builder)
    {
        $builder->macro('withoutInactive', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_active', 1);
        });
    }

    /**
     * Add the only-inactive extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addOnlyInactive(Builder $builder)
    {
        $builder->macro('onlyInactive', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_active', 0);
        });
    }
}
