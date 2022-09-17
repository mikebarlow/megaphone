<?php

namespace MBarlow\Megaphone\Console;

use Illuminate\Console\Command;
use Illuminate\Notifications\DatabaseNotification;

class ClearOldNotifications extends Command
{
    protected $signature = 'megaphone:clear-announcements';

    protected $description = 'Clear old read announcements';

    public function handle()
    {
        now()->sub(config('megaphone.clearAfter'))->toDateTimeString();

        DatabaseNotification::whereIn('type', getMegaphoneTypes())
            ->whereNotNull('read_at')
            ->where('created_at', '<', now()->sub(config('megaphone.clearAfter')))
            ->delete();
    }
}
