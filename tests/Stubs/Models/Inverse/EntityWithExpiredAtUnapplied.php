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

use Cog\Flag\Traits\Inverse\HasExpiredAt;
use Illuminate\Database\Eloquent\Model;

final class EntityWithExpiredAtUnapplied extends Model
{
    use HasExpiredAt;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entity_with_expired_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Determine if ExpiredAtScope should be applied by default.
     *
     * @return bool
     */
    public function shouldApplyExpiredAtScope(): bool
    {
        return false;
    }
}
