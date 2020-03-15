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

use Illuminate\Support\Facades\Date;

trait HasCommentAtHelpers
{
    public function initializeHasApprovedAtHelpers(): void
    {
        $this->dates[] = 'commentable_at';
    }

    public function isComment(): bool
    {
        return !is_null($this->getAttributeValue('commentable_at'));
    }

    public function isNotApproved(): bool
    {
        return !$this->isComment();
    }

    public function comment(): void
    {
        $this->setAttribute('commentable_at', Date::now());
        $this->save();

        $this->fireModelEvent('comment', false);
    }

    public function undoComment(): void
    {
        $this->setAttribute('commentable_at', null);
        $this->save();

        $this->fireModelEvent('commentUndone', false);
    }
}
