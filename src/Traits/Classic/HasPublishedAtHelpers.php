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

use Illuminate\Support\Facades\Date;

trait HasPublishedAtHelpers
{
    public function initializeHasPublishedAtHelpers(): void
    {
        $this->dates[] = 'published_at';
    }

    /**
     * If entity is published.
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return !is_null($this->getAttributeValue('published_at'));
    }

    /**
     * If entity is unpublished.
     *
     * @return bool
     */
    public function isUnpublished(): bool
    {
        return !$this->isPublished();
    }

    /**
     * Mark entity as published.
     *
     * @return void
     */
    public function publish(): void
    {
        $this->setAttribute('published_at', Date::now());
        $this->save();

        $this->fireModelEvent('published', false);
    }

    /**
     * Mark entity as unpublished.
     *
     * @return void
     */
    public function unpublish(): void
    {
        $this->setAttribute('published_at', null);
        $this->save();

        $this->fireModelEvent('unpublished', false);
    }
}
