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

namespace Cog\Tests\Flag\Stubs\Models\Classic;

use Cog\Flag\Traits\Classic\HasInvitedFlag;
use Illuminate\Database\Eloquent\Model;

final class EntityWithInvitedFlagUnapplied extends Model
{
    use HasInvitedFlag;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entity_with_invited_flag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_invited' => 'bool',
    ];

    /**
     * Determine if InvitedFlagScope should be applied by default.
     *
     * @return bool
     */
    public function shouldApplyInvitedFlagScope(): bool
    {
        return false;
    }
}
