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

use Cog\Flag\Traits\Classic\HasVerifiedFlag;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EntityWithVerifiedFlag.
 *
 * @package Cog\Tests\Flag\Stubs\Models\Classic
 */
class EntityWithVerifiedFlag extends Model
{
    use HasVerifiedFlag;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entity_with_verified_flag';

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
        'is_verified' => 'bool',
    ];
}
