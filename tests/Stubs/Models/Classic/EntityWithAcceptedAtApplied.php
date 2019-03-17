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

use Cog\Flag\Traits\Classic\HasAcceptedAt;
use Illuminate\Database\Eloquent\Model;

final class EntityWithAcceptedAtApplied extends Model
{
    use HasAcceptedAt;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entity_with_accepted_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Determine if AcceptedAtScope should be applied by default.
     *
     * @return bool
     */
    public function shouldApplyAcceptedAtScope(): bool
    {
        return true;
    }
}
