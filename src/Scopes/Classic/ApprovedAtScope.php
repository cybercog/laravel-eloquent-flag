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

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Class ApprovedAtScope.
 *
 * @package Cog\Flag\Scopes\Classic
 */
class ApprovedAtScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['Approve', 'Disapprove', 'WithDisapproved', 'WithoutDisapproved', 'OnlyDisapproved'];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $builder, Model $model)
    {
        return $builder->whereNotNull('approved_at');
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
     * Add the `approve` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addApprove(Builder $builder)
    {
        $builder->macro('approve', function (Builder $builder) {
            $builder->withDisapproved();

            return $builder->update(['approved_at' => Carbon::now()]);
        });
    }

    /**
     * Add the `disapprove` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addDisapprove(Builder $builder)
    {
        $builder->macro('disapprove', function (Builder $builder) {
            return $builder->update(['approved_at' => null]);
        });
    }

    /**
     * Add the `withDisapproved` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithDisapproved(Builder $builder)
    {
        $builder->macro('withDisapproved', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutDisapproved` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutDisapproved(Builder $builder)
    {
        $builder->macro('withoutDisapproved', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->whereNotNull('approved_at');
        });
    }

    /**
     * Add the `onlyDisapproved` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyDisapproved(Builder $builder)
    {
        $builder->macro('onlyDisapproved', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->whereNull('approved_at');
        });
    }
}
