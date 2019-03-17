<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Flag\Traits\Classic;

trait HasPublishedFlagHelpers
{
    public function initializeHasPublishedFlagHelpers(): void
    {
        $this->casts['is_published'] = 'boolean';
    }

    public function isPublished(): bool
    {
        return $this->getAttributeValue('is_published');
    }

    public function isNotPublished(): bool
    {
        return !$this->isPublished();
    }

    public function publish(): void
    {
        $this->setAttribute('is_published', true);
        $this->save();

        $this->fireModelEvent('published', false);
    }

    public function undoPublish(): void
    {
        $this->setAttribute('is_published', false);
        $this->save();

        $this->fireModelEvent('unpublished', false);
    }
}
