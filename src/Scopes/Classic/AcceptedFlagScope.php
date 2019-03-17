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

final class AcceptedFlagScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = [
        'Accept',
        'UndoAccept',
        'WithNotAccepted',
        'WithoutNotAccepted',
        'OnlyNotAccepted',
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
        if (!method_exists($model, 'shouldApplyAcceptedFlagScope') || !$model->shouldApplyAcceptedFlagScope()) {
            return;
        }

        $builder->where('is_accepted', 1);
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
     * Add the `accept` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addAccept(Builder $builder): void
    {
        $builder->macro('accept', function (Builder $builder) {
            $builder->withNotAccepted();

            return $builder->update(['is_accepted' => 1]);
        });
    }

    /**
     * Add the `undoAccept` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addUndoAccept(Builder $builder): void
    {
        $builder->macro('undoAccept', function (Builder $builder) {
            return $builder->update(['is_accepted' => 0]);
        });
    }

    /**
     * Add the `withNotAccepted` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithNotAccepted(Builder $builder): void
    {
        $builder->macro('withNotAccepted', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutNotAccepted` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutNotAccepted(Builder $builder): void
    {
        $builder->macro('withoutNotAccepted', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_accepted', 1);
        });
    }

    /**
     * Add the `onlyNotAccepted` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyNotAccepted(Builder $builder): void
    {
        $builder->macro('onlyNotAccepted', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_accepted', 0);
        });
    }
}
