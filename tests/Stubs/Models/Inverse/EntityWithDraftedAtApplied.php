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

use Cog\Flag\Traits\Inverse\HasDraftedAt;
use Illuminate\Database\Eloquent\Model;

final class EntityWithDraftedAtApplied extends Model
{
    use HasDraftedAt;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entity_with_drafted_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Determine if DraftedAtScope should be applied by default.
     *
     * @return bool
     */
    public function shouldApplyDraftedAtScope(): bool
    {
        return true;
    }
}
