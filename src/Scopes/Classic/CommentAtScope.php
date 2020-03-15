<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Sivan Wolberg <sivan@wolberg.pro>
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

final class CommentAtScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = [
        'Comment',
        'UndoComment',
        'WithNotComment',
        'WithoutNotComment',
        'OnlyNotComment',
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
        if (method_exists($model, 'shouldApplyCommentAtScope') && $model->shouldApplyVerifiedAtScope()) {
            $builder->whereNotNull('commentable_at');
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
     * Add the `comment` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addComment(Builder $builder): void
    {
        $builder->macro('comment', function (Builder $builder) {
            $builder->withNotVerified();

            return $builder->update(['commentable_at' => Date::now()]);
        });
    }

    /**
     * Add the `undoComment` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addUndoComment(Builder $builder): void
    {
        $builder->macro('undoComment', function (Builder $builder) {
            return $builder->update(['commentable_at' => null]);
        });
    }

    /**
     * Add the `withNotComment` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithNotComment(Builder $builder): void
    {
        $builder->macro('withNotComment', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutNotComment` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutNotComment(Builder $builder): void
    {
        $builder->macro('withoutNotComment', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->whereNotNull('commentable_at');
        });
    }

    /**
     * Add the `onlyNotComment` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyNotComment(Builder $builder): void
    {
        $builder->macro('onlyNotComment', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->whereNull('commentable_at');
        });
    }
}
