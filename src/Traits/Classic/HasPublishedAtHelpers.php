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

namespace Cog\Flag\Traits\Classic;

use Illuminate\Support\Facades\Date;

trait HasPublishedAtHelpers
{
    public function initializeHasPublishedAtHelpers(): void
    {
        $this->casts['published_at'] = 'datetime';
    }

    public function isPublished(): bool
    {
        return !is_null($this->getAttributeValue('published_at'));
    }

    public function isNotPublished(): bool
    {
        return !$this->isPublished();
    }

    public function publish(): void
    {
        $this->setAttribute('published_at', Date::now());
        $this->save();

        $this->fireModelEvent('published', false);
    }

    public function undoPublish(): void
    {
        $this->setAttribute('published_at', null);
        $this->save();

        $this->fireModelEvent('publishedUndone', false);
    }
}
