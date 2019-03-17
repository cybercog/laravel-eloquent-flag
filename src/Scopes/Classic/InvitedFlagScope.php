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

final class InvitedFlagScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = [
        'Invite',
        'UndoInvite',
        'WithNotInvited',
        'WithoutNotInvited',
        'OnlyNotInvited',
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
        if (method_exists($model, 'shouldApplyInvitedFlagScope') && !$model->shouldApplyInvitedFlagScope()) {
            return;
        }

        $builder->where('is_invited', 1);
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
     * Add the `invite` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addInvite(Builder $builder): void
    {
        $builder->macro('invite', function (Builder $builder) {
            $builder->withNotInvited();

            return $builder->update(['is_invited' => 1]);
        });
    }

    /**
     * Add the `undoInvite` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addUndoInvite(Builder $builder): void
    {
        $builder->macro('undoInvite', function (Builder $builder) {
            return $builder->update(['is_invited' => 0]);
        });
    }

    /**
     * Add the `withNotInvited` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithNotInvited(Builder $builder): void
    {
        $builder->macro('withNotInvited', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutNotInvited` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutNotInvited(Builder $builder): void
    {
        $builder->macro('withoutNotInvited', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_invited', 1);
        });
    }

    /**
     * Add the `onlyNotInvited` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyNotInvited(Builder $builder): void
    {
        $builder->macro('onlyNotInvited', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_invited', 0);
        });
    }
}
