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

namespace Cog\Flag\Scopes\Inverse;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

final class DraftedFlagScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = [
        'UndoDraft',
        'Draft',
        'WithDrafted',
        'WithoutDrafted',
        'OnlyDrafted',
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
        if (method_exists($model, 'shouldApplyDraftedFlagScope') && !$model->shouldApplyDraftedFlagScope()) {
            return;
        }

        $builder->where('is_drafted', 0);
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
     * Add the `undoDraft` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addUndoDraft(Builder $builder): void
    {
        $builder->macro('undoDraft', function (Builder $builder) {
            $builder->withDrafted();

            return $builder->update(['is_drafted' => 0]);
        });
    }

    /**
     * Add the `draft` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addDraft(Builder $builder): void
    {
        $builder->macro('draft', function (Builder $builder) {
            return $builder->update(['is_drafted' => 1]);
        });
    }

    /**
     * Add the `withDrafted` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithDrafted(Builder $builder): void
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
    protected function addWithoutDrafted(Builder $builder): void
    {
        $builder->macro('withoutDrafted', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_drafted', 0);
        });
    }

    /**
     * Add the `onlyDrafted` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyDrafted(Builder $builder): void
    {
        $builder->macro('onlyDrafted', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_drafted', 1);
        });
    }
}
