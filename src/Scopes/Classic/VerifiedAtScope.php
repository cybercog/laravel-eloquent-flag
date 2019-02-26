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
use Illuminate\Support\Carbon;

final class VerifiedAtScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = [
        'Verify',
        'Unverify',
        'WithUnverified',
        'WithoutUnverified',
        'OnlyUnverified',
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
        if (method_exists($model, 'shouldApplyVerifiedAtScope') && !$model->shouldApplyVerifiedAtScope()) {
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
            $builder->withUnverified();

            return $builder->update(['verified_at' => Carbon::now()]);
        });
    }

    /**
     * Add the `unverify` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addUnverify(Builder $builder): void
    {
        $builder->macro('unverify', function (Builder $builder) {
            return $builder->update(['verified_at' => null]);
        });
    }

    /**
     * Add the `withUnverified` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithUnverified(Builder $builder): void
    {
        $builder->macro('withUnverified', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutUnverified` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutUnverified(Builder $builder): void
    {
        $builder->macro('withoutUnverified', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->whereNotNull('verified_at');
        });
    }

    /**
     * Add the `onlyUnverified` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyUnverified(Builder $builder): void
    {
        $builder->macro('onlyUnverified', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->whereNull('verified_at');
        });
    }
}
