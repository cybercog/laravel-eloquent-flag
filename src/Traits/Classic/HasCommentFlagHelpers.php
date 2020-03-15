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

trait HasCommentFlagHelpers
{
    public function initializeHasCommwntFlagHelpers(): void
    {
        $this->casts['is_commentable'] = 'boolean';
    }

    public function isComment(): bool
    {
        return $this->getAttributeValue('is_commentable');
    }

    public function isNotComment(): bool
    {
        return !$this->isComment();
    }

    public function comment(): void
    {
        $this->setAttribute('is_commentable', true);
        $this->save();

        $this->fireModelEvent('comment', false);
    }

    public function undoComment(): void
    {
        $this->setAttribute('is_commentable', false);
        $this->save();

        $this->fireModelEvent('approvedComment', false);
    }
}
