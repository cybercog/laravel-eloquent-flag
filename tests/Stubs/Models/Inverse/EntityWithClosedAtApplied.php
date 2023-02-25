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

namespace Cog\Tests\Laravel\Flag\Stubs\Models\Inverse;

use Cog\Flag\Traits\Inverse\HasClosedAt;
use Illuminate\Database\Eloquent\Model;

final class EntityWithClosedAtApplied extends Model
{
    use HasClosedAt;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entity_with_closed_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Determine if ClosedAtScope should be applied by default.
     *
     * @return bool
     */
    public function shouldApplyClosedAtScope(): bool
    {
        return true;
    }
}
