<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Tests\Stubs\Models\Inverse;

use Cog\Flag\Traits\Inverse\HasClosedFlag;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EntityWithClosedFlag.
 *
 * @package Cog\Flag\Tests\Stubs\Models\Inverse
 */
class EntityWithClosedFlag extends Model
{
    use HasClosedFlag;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entity_with_closed_flag';

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
        'is_closed' => 'bool',
    ];
}
