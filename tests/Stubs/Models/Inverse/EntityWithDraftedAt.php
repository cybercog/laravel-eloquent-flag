<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Tests\Flag\Stubs\Models\Inverse;

use Cog\Flag\Traits\Inverse\HasDraftedAt;
use Illuminate\Database\Eloquent\Model;

class EntityWithDraftedAt extends Model
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'drafted_at' => 'datetime',
    ];
}
