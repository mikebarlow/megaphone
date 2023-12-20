<?php

namespace MBarlow\Megaphone;

use Illuminate\Database\Eloquent\Model;
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

    public function canAccessNotifications(Model $notifiable): bool
    {
        return $this->is($notifiable) || $this->can(config('megaphone.access-notifications-permission-name'), $notifiable);
    }
}
