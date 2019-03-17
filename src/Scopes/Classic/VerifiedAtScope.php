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

final class VerifiedAtScope implements Scope
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
        if (!method_exists($model, 'shouldApplyVerifiedAtScope') || !$model->shouldApplyVerifiedAtScope()) {
            return;
        }

        $builder->whereNotNull('verified_at');
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

            return $builder->update(['verified_at' => Date::now()]);
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
            return $builder->update(['verified_at' => null]);
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
            return $builder->withoutGlobalScope($this)->whereNotNull('verified_at');
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
            return $builder->withoutGlobalScope($this)->whereNull('verified_at');
        });
    }
}
