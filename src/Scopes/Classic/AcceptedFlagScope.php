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
 * Class AcceptedFlagScope.
 *
 * @package Cog\Flag\Scopes\Classic
 */
class AcceptedFlagScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['Accept', 'Reject', 'WithRejected', 'WithoutRejected', 'OnlyRejected'];

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
            $builder->withRejected();

            return $builder->update(['is_accepted' => 1]);
        });
    }

    /**
     * Add the `reject` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addReject(Builder $builder)
    {
        $builder->macro('reject', function (Builder $builder) {
            return $builder->update(['is_accepted' => 0]);
        });
    }

    /**
     * Add the `withRejected` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithRejected(Builder $builder)
    {
        $builder->macro('withRejected', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutRejected` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutRejected(Builder $builder)
    {
        $builder->macro('withoutRejected', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_accepted', 1);
        });
    }

    /**
     * Add the `onlyRejected` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyRejected(Builder $builder)
    {
        $builder->macro('onlyRejected', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_accepted', 0);
        });
    }
}
