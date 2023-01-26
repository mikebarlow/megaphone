<?php

namespace MBarlow\Megaphone\Livewire;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Livewire\Component;

class Megaphone extends Component
{
    public $notifiable_id;

    public $announcements;

    public $unread;

    public $showCount;

    public $rules = [
        'unread' => 'required',
        'announcements' => 'required',
    ];

    public function mount(Request $request)
    {
        $this->notifiable_id = $request->user()->id ?? null;
        $notifiable = $this->getNotifiable();
        $this->loadAnnouncements($notifiable);
        $this->showCount = config('megaphone.showCount', true);
    }

    public function getNotifiable()
    {
        return config('megaphone.model')::find($this->notifiable_id);
    }

    public function loadAnnouncements($notifiable)
    {
        $this->unread = $this->announcements = collect([]);

        if ($notifiable === null || get_class($notifiable) !== config('megaphone.model')) {
            return;
        }

        $announcements = $notifiable->announcements()->get();
        $this->unread = $announcements->whereNull('read_at');
        $this->announcements = $announcements->whereNotNull('read_at');
    }

    public function render()
    {
        return view('megaphone::megaphone');
    }

    public function markAsRead(DatabaseNotification $notification)
    {
        $notification->markAsRead();
        $this->loadAnnouncements($this->getNotifiable());
    }
}
