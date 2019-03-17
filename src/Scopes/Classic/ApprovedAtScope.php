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
use Illuminate\Support\Facades\Date;

final class ApprovedAtScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = [
        'Approve',
        'UndoApprove',
        'WithNotApproved',
        'WithoutNotApproved',
        'OnlyNotApproved',
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
        if (method_exists($model, 'shouldApplyApprovedAtScope') && $model->shouldApplyApprovedAtScope()) {
            $builder->whereNotNull('approved_at');
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
     * Add the `approve` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addApprove(Builder $builder): void
    {
        $builder->macro('approve', function (Builder $builder) {
            $builder->withNotApproved();

            return $builder->update(['approved_at' => Date::now()]);
        });
    }

    /**
     * Add the `undoApprove` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addUndoApprove(Builder $builder): void
    {
        $builder->macro('undoApprove', function (Builder $builder) {
            return $builder->update(['approved_at' => null]);
        });
    }

    /**
     * Add the `withNotApproved` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithNotApproved(Builder $builder): void
    {
        $builder->macro('withNotApproved', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutNotApproved` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutNotApproved(Builder $builder): void
    {
        $builder->macro('withoutNotApproved', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->whereNotNull('approved_at');
        });
    }

    /**
     * Add the `onlyNotApproved` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyNotApproved(Builder $builder): void
    {
        $builder->macro('onlyNotApproved', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->whereNull('approved_at');
        });
    }
}
