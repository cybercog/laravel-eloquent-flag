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

final class VerifiedFlagScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = [
        'Verify',
        'UndoVerify',
        'WithNotVerified',
        'WithoutNotVerified',
        'OnlyNotVerified',
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
        if (method_exists($model, 'shouldApplyVerifiedFlagScope') && $model->shouldApplyVerifiedFlagScope()) {
            $builder->where('is_verified', 1);
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
     * Add the `verify` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addVerify(Builder $builder): void
    {
        $builder->macro('verify', function (Builder $builder) {
            $builder->withNotVerified();

            return $builder->update(['is_verified' => 1]);
        });
    }

    /**
     * Add the `undoVerify` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addUndoVerify(Builder $builder): void
    {
        $builder->macro('undoVerify', function (Builder $builder) {
            return $builder->update(['is_verified' => 0]);
        });
    }

    /**
     * Add the `withNotVerified` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithNotVerified(Builder $builder): void
    {
        $builder->macro('withNotVerified', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutNotVerified` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutNotVerified(Builder $builder): void
    {
        $builder->macro('withoutNotVerified', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_verified', 1);
        });
    }

    /**
     * Add the `onlyNotVerified` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyNotVerified(Builder $builder): void
    {
        $builder->macro('onlyNotVerified', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_verified', 0);
        });
    }
}
