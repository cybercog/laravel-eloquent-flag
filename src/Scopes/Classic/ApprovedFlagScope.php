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
 * Class ApprovedFlagScope.
 *
 * @package Cog\Flag\Scopes\Classic
 */
class ApprovedFlagScope implements Scope
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
        return $builder->where('is_approved', 1);
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

            return $builder->update(['is_approved' => 1]);
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
            return $builder->update(['is_approved' => 0]);
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
            return $builder->withoutGlobalScope($this)->where('is_approved', 1);
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
            return $builder->withoutGlobalScope($this)->where('is_approved', 0);
        });
    }
}
