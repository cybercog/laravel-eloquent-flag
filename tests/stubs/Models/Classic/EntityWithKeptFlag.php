<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Tests\Stubs\Models\Classic;

use Cog\Flag\Traits\Classic\HasKeptFlag;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EntityWithKeptFlag.
 *
 * @package Cog\Flag\Tests\Stubs\Models\Classic
 */
class EntityWithKeptFlag extends Model
{
    use HasKeptFlag;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entity_with_kept_flag';

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
        'is_kept' => 'bool',
    ];
}
