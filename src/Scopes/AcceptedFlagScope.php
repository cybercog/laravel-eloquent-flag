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

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class AcceptedFlagScope.
 *
 * @package Cog\Flag\Scopes
 */
class AcceptedFlagScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['Accept', 'Unaccept', 'WithUnaccepted', 'WithoutUnaccepted', 'OnlyUnaccepted'];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $builder, Model $model)
    {
        return $builder->where('is_accepted', 1);
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
     * Add the `accept` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addAccept(Builder $builder)
    {
        $builder->macro('accept', function (Builder $builder) {
            $builder->withUnaccepted();

            return $builder->update(['is_accepted' => 1]);
        });
    }

    /**
     * Add the `unaccept` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addUnaccept(Builder $builder)
    {
        $builder->macro('unaccept', function (Builder $builder) {
            return $builder->update(['is_accepted' => 0]);
        });
    }

    /**
     * Add the `withUnaccepted` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithUnaccepted(Builder $builder)
    {
        $builder->macro('withUnaccepted', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutUnaccepted` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutUnaccepted(Builder $builder)
    {
        $builder->macro('withoutUnaccepted', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_accepted', 1);
        });
    }

    /**
     * Add the `onlyUnaccepted` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyUnaccepted(Builder $builder)
    {
        $builder->macro('onlyUnaccepted', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_accepted', 0);
        });
    }
}
