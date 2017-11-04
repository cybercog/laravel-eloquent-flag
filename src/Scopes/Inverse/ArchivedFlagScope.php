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
 * Class ArchivedFlagScope.
 *
 * @package Cog\Flag\Scopes\Inverse
 */
class ArchivedFlagScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['Unarchive', 'Archive', 'WithArchived', 'WithoutArchived', 'OnlyArchived'];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $builder, Model $model)
    {
        if (method_exists($model, 'shouldApplyArchivedFlagScope') && !$model->shouldApplyArchivedFlagScope()) {
            return $builder;
        }

        return $builder->where('is_archived', 0);
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
     * Add the `unarchive` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addUnarchive(Builder $builder)
    {
        $builder->macro('unarchive', function (Builder $builder) {
            $builder->withArchived();

            return $builder->update(['is_archived' => 0]);
        });
    }

    /**
     * Add the `archive` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addArchive(Builder $builder)
    {
        $builder->macro('archive', function (Builder $builder) {
            return $builder->update(['is_archived' => 1]);
        });
    }

    /**
     * Add the `withArchived` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithArchived(Builder $builder)
    {
        $builder->macro('withArchived', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutArchived` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutArchived(Builder $builder)
    {
        $builder->macro('withoutArchived', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_archived', 0);
        });
    }

    /**
     * Add the `onlyArchived` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyArchived(Builder $builder)
    {
        $builder->macro('onlyArchived', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_archived', 1);
        });
    }
}
