<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Scopes\Inverse;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Class EndedFlagScope.
 *
 * @package Cog\Flag\Scopes\Inverse
 */
class EndedFlagScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['Unend', 'End', 'WithEnded', 'WithoutEnded', 'OnlyEnded'];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $builder, Model $model)
    {
        if (method_exists($model, 'shouldApplyEndedFlagScope') && !$model->shouldApplyEndedFlagScope()) {
            return $builder;
        }

        return $builder->where('is_ended', 0);
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
     * Add the `unend` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addUnend(Builder $builder)
    {
        $builder->macro('unend', function (Builder $builder) {
            $builder->withEnded();

            return $builder->update(['is_ended' => 0]);
        });
    }

    /**
     * Add the `end` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addEnd(Builder $builder)
    {
        $builder->macro('end', function (Builder $builder) {
            return $builder->update(['is_ended' => 1]);
        });
    }

    /**
     * Add the `withEnded` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithEnded(Builder $builder)
    {
        $builder->macro('withEnded', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutEnded` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutEnded(Builder $builder)
    {
        $builder->macro('withoutEnded', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_ended', 0);
        });
    }

    /**
     * Add the `onlyEnded` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyEnded(Builder $builder)
    {
        $builder->macro('onlyEnded', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_ended', 1);
        });
    }
}
