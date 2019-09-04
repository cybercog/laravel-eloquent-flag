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

namespace Cog\Flag\Scopes\Classic;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

final class KeptFlagScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = [
        'Keep',
        'UndoKeep',
        'WithNotKept',
        'WithoutNotKept',
        'OnlyNotKept',
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
        if (method_exists($model, 'shouldApplyKeptFlagScope') && $model->shouldApplyKeptFlagScope()) {
            $builder->where('is_kept', 1);
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
     * Add the `keep` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addKeep(Builder $builder): void
    {
        $builder->macro('keep', function (Builder $builder) {
            $builder->withNotKept();

            return $builder->update(['is_kept' => 1]);
        });
    }

    /**
     * Add the `undoKeep` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addUndoKeep(Builder $builder): void
    {
        $builder->macro('undoKeep', function (Builder $builder) {
            return $builder->update(['is_kept' => 0]);
        });
    }

    /**
     * Add the `withNotKept` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithNotKept(Builder $builder): void
    {
        $builder->macro('withNotKept', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutNotKept` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutNotKept(Builder $builder): void
    {
        $builder->macro('withoutNotKept', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_kept', 1);
        });
    }

    /**
     * Add the `onlyNotKept` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyNotKept(Builder $builder): void
    {
        $builder->macro('onlyNotKept', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_kept', 0);
        });
    }
}
