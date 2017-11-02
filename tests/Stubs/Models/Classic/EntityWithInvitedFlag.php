<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Tests\Flag\Stubs\Models\Classic;

use Cog\Flag\Traits\Classic\HasInvitedFlag;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EntityWithInvitedFlag.
 *
 * @package Cog\Tests\Flag\Stubs\Models\Classic
 */
class EntityWithInvitedFlag extends Model
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
}
