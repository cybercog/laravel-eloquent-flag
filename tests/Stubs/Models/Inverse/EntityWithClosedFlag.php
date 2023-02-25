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

use Cog\Flag\Traits\Inverse\HasClosedFlag;
use Illuminate\Database\Eloquent\Model;

final class EntityWithClosedFlag extends Model
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
}
