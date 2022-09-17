<?php

namespace MBarlow\Megaphone;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasMegaphone
{
    public function announcements(): MorphMany
    {
        return $this->notifications()
            ->whereIn(
                'type',
                getMegaphoneTypes()
            );
    }
}
