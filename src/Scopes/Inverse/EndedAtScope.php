<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <anton@komarev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Flag\Scopes\Inverse;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Date;

final class EndedAtScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = [
        'UndoEnd',
        'End',
        'WithEnded',
        'WithoutEnded',
        'OnlyEnded',
    ];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (method_exists($model, 'shouldApplyEndedAtScope') && $model->shouldApplyEndedAtScope()) {
            $builder->whereNull('ended_at');
        }
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    public function extend(Builder $builder): void
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    /**
     * Add the `undoEnd` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addUndoEnd(Builder $builder): void
    {
        $builder->macro('undoEnd', function (Builder $builder) {
            $builder->withEnded();

            return $builder->update(['ended_at' => null]);
        });
    }

    /**
     * Add the `end` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addEnd(Builder $builder): void
    {
        $builder->macro('end', function (Builder $builder) {
            return $builder->update(['ended_at' => Date::now()]);
        });
    }

    /**
     * Add the `withEnded` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithEnded(Builder $builder): void
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
    protected function addWithoutEnded(Builder $builder): void
    {
        $builder->macro('withoutEnded', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->whereNull('ended_at');
        });
    }

    /**
     * Add the `onlyEnded` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyEnded(Builder $builder): void
    {
        $builder->macro('onlyEnded', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->whereNotNull('ended_at');
        });
    }
}
