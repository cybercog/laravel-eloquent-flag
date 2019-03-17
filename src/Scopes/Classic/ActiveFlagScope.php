<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Flag\Scopes\Classic;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

final class ActiveFlagScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = [
        'Activate',
        'UndoActivate',
        'WithNotActivated',
        'WithoutNotActivated',
        'OnlyNotActivated',
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
        if (method_exists($model, 'shouldApplyActiveFlagScope') && $model->shouldApplyActiveFlagScope()) {
            $builder->where('is_active', 1);
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
     * Add the `activate` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addActivate(Builder $builder): void
    {
        $builder->macro('activate', function (Builder $builder) {
            $builder->withNotActivated();

            return $builder->update(['is_active' => 1]);
        });
    }

    /**
     * Add the `undoActivate` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addUndoActivate(Builder $builder): void
    {
        $builder->macro('undoActivate', function (Builder $builder) {
            return $builder->update(['is_active' => 0]);
        });
    }

    /**
     * Add the `withNotActivated` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithNotActivated(Builder $builder): void
    {
        $builder->macro('withNotActivated', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutNotActivated` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutNotActivated(Builder $builder): void
    {
        $builder->macro('withoutNotActivated', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_active', 1);
        });
    }

    /**
     * Add the `onlyNotActivated` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyNotActivated(Builder $builder): void
    {
        $builder->macro('onlyNotActivated', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_active', 0);
        });
    }
}
