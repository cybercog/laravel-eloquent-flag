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
 * Class ApprovedFlagScope.
 *
 * @package Cog\Flag\Scopes
 */
class ApprovedFlagScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['Approve', 'Unapprove', 'WithUnapproved', 'WithoutUnapproved', 'OnlyUnapproved'];

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
            $builder->withUnapproved();

            return $builder->update(['is_approved' => 1]);
        });
    }

    /**
     * Add the `unapprove` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addUnapprove(Builder $builder)
    {
        $builder->macro('unapprove', function (Builder $builder) {
            return $builder->update(['is_approved' => 0]);
        });
    }

    /**
     * Add the `withUnapproved` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithUnapproved(Builder $builder)
    {
        $builder->macro('withUnapproved', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutUnapproved` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutUnapproved(Builder $builder)
    {
        $builder->macro('withoutUnapproved', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_approved', 1);
        });
    }

    /**
     * Add the `onlyUnapproved` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyUnapproved(Builder $builder)
    {
        $builder->macro('onlyUnapproved', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_approved', 0);
        });
    }
}
