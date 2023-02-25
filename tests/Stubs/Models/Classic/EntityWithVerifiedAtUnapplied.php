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

namespace Cog\Tests\Laravel\Flag\Stubs\Models\Classic;

use Cog\Flag\Traits\Classic\HasVerifiedAt;
use Illuminate\Database\Eloquent\Model;

final class EntityWithVerifiedAtUnapplied extends Model
{
    use HasVerifiedAt;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entity_with_verified_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Determine if VerifiedAtScope should be applied by default.
     *
     * @return bool
     */
    public function shouldApplyVerifiedAtScope(): bool
    {
        return false;
    }
}
