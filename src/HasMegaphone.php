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
                $this->getMegaphoneTypes()
            );
    }

    public function getMegaphoneTypes(): array
    {
        return array_merge(
            (array) config('megaphone.types', []),
            array_keys((array) config('megaphone.customTypes', []))
        );
    }
}
