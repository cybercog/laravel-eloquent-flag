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
 * Class VerifiedFlagScope.
 *
 * @package Cog\Flag\Scopes
 */
class VerifiedFlagScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['Verify', 'Unverify', 'WithUnverified', 'WithoutUnverified', 'OnlyUnverified'];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $builder, Model $model)
    {
        return $builder->where('is_verified', 1);
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
     * Add the `verify` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addVerify(Builder $builder)
    {
        $builder->macro('verify', function (Builder $builder) {
            $builder->withUnverified();

            return $builder->update(['is_verified' => 1]);
        });
    }

    /**
     * Add the `unverify` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addUnverify(Builder $builder)
    {
        $builder->macro('unverify', function (Builder $builder) {
            return $builder->update(['is_verified' => 0]);
        });
    }

    /**
     * Add the `withUnverified` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithUnverified(Builder $builder)
    {
        $builder->macro('withUnverified', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutUnverified` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutUnverified(Builder $builder)
    {
        $builder->macro('withoutUnverified', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_verified', 1);
        });
    }

    /**
     * Add the `onlyUnverified` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyUnverified(Builder $builder)
    {
        $builder->macro('onlyUnverified', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_verified', 0);
        });
    }
}
