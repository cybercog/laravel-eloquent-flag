<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Sivan Wolberg <sivan@wolberg.pro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Tests\Flag\Stubs\Models\Classic;

use Cog\Flag\Traits\Classic\HasCommentAt;
use Illuminate\Database\Eloquent\Model;

final class EntityWithCommentAt extends Model
{
    use HasCommentAt;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entity_with_commentable_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
