<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) CyberCog <support@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Tests\Stubs\Models\Inverse;

use Cog\Flag\Traits\Inverse\HasExpiredFlag;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EntityWithExpiredFlag.
 *
 * @package Cog\Flag\Tests\Stubs\Models\Inverse
 */
class EntityWithExpiredFlag extends Model
{
    use HasExpiredFlag;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entity_with_expired_flag';

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
        'is_expired' => 'bool',
    ];
}
