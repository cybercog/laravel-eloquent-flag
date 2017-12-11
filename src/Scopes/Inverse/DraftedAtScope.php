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

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Class DraftedAtScope.
 *
 * @package Cog\Flag\Scopes\Inverse
 */
class DraftedAtScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['Undraft', 'Draft', 'WithDrafted', 'WithoutDrafted', 'OnlyDrafted'];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $builder, Model $model)
    {
        if (method_exists($model, 'shouldApplyDraftedAtScope') && !$model->shouldApplyDraftedAtScope()) {
            return $builder;
        }

        return $builder->whereNull('drafted_at');
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
     * Add the `undraft` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addUndraft(Builder $builder)
    {
        $builder->macro('undraft', function (Builder $builder) {
            $builder->withDrafted();

            return $builder->update(['drafted_at' => null]);
        });
    }

    /**
     * Add the `draft` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addDraft(Builder $builder)
    {
        $builder->macro('draft', function (Builder $builder) {
            return $builder->update(['drafted_at' => Carbon::now()]);
        });
    }

    /**
     * Add the `withDrafted` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithDrafted(Builder $builder)
    {
        $builder->macro('withDrafted', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutDrafted` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutDrafted(Builder $builder)
    {
        $builder->macro('withoutDrafted', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->whereNull('drafted_at');
        });
    }

    /**
     * Add the `onlyDrafted` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyDrafted(Builder $builder)
    {
        $builder->macro('onlyDrafted', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->whereNotNull('drafted_at');
        });
    }
}
