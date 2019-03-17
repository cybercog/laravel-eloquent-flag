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

final class AcceptedAtScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = [
        'Accept',
        'Reject',
        'WithRejected',
        'WithoutRejected',
        'OnlyRejected',
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
        $builder->whereNotNull('accepted_at');
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
            $builder->withRejected();

            return $builder->update(['accepted_at' => Date::now()]);
        });
    }

    /**
     * Add the `reject` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addReject(Builder $builder): void
    {
        $builder->macro('reject', function (Builder $builder) {
            return $builder->update(['accepted_at' => null]);
        });
    }

    /**
     * Add the `withRejected` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithRejected(Builder $builder): void
    {
        $builder->macro('withRejected', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutRejected` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutRejected(Builder $builder): void
    {
        $builder->macro('withoutRejected', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->whereNotNull('accepted_at');
        });
    }

    /**
     * Add the `onlyRejected` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyRejected(Builder $builder): void
    {
        $builder->macro('onlyRejected', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->whereNull('accepted_at');
        });
    }
}
