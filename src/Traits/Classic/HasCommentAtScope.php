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

namespace Cog\Flag\Traits\Classic;

use Cog\Flag\Scopes\Classic\CommentAtScope;

trait HasCommentAtScope
{
    /**
     * Boot the HasApprovedAtScope trait for a model.
     *
     * @return void
     */
    public static function bootHasCommentAtScope(): void
    {
        static::addGlobalScope(new CommentAtScope());
    }
}
