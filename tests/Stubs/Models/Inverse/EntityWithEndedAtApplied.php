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

use Cog\Flag\Traits\Inverse\HasEndedAt;
use Illuminate\Database\Eloquent\Model;

final class EntityWithEndedAtApplied extends Model
{
    use HasEndedAt;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entity_with_ended_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Determine if EndedAtScope should be applied by default.
     *
     * @return bool
     */
    public function shouldApplyEndedAtScope(): bool
    {
        return true;
    }
}
