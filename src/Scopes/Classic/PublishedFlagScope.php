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
 * Class PublishedFlagScope.
 *
 * @package Cog\Flag\Scopes\Classic
 */
class PublishedFlagScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['Publish', 'Unpublish', 'WithUnpublished', 'WithoutUnpublished', 'OnlyUnpublished'];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $builder, Model $model)
    {
        if (method_exists($model, 'shouldApplyPublishedFlagScope') && !$model->shouldApplyPublishedFlagScope()) {
            return $builder;
        }

        return $builder->where('is_published', 1);
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
     * Add the `publish` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addPublish(Builder $builder)
    {
        $builder->macro('publish', function (Builder $builder) {
            $builder->withUnpublished();

            return $builder->update(['is_published' => 1]);
        });
    }

    /**
     * Add the `unpublish` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addUnpublish(Builder $builder)
    {
        $builder->macro('unpublish', function (Builder $builder) {
            return $builder->update(['is_published' => 0]);
        });
    }

    /**
     * Add the `withUnpublished` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithUnpublished(Builder $builder)
    {
        $builder->macro('withUnpublished', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutUnpublished` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutUnpublished(Builder $builder)
    {
        $builder->macro('withoutUnpublished', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_published', 1);
        });
    }

    /**
     * Add the `onlyUnpublished` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyUnpublished(Builder $builder)
    {
        $builder->macro('onlyUnpublished', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_published', 0);
        });
    }
}
