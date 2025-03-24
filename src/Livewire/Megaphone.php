<?php

namespace MBarlow\Megaphone\Livewire;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Livewire\Component;

class Megaphone extends Component
{
    public $notifiableId;

    public $announcements;

    public $unread;

    public $showCount;

    protected $listeners = [
        'notification-link-clicked' => 'markAsRead',
    ];

    public $rules = [
        'unread' => 'required',
        'announcements' => 'required',
    ];

    public function mount(Request $request)
    {
        if (empty($this->notifiableId) && $request->user() !== null) {
            $this->notifiableId = $request->user()->id;
        }
        $this->showCount = config('megaphone.showCount', true);
    }

    public function getNotifiable()
    {
        return config('megaphone.model')::find($this->notifiableId);
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
        $this->loadAnnouncements($this->getNotifiable());
        return view('megaphone::megaphone');
    }

    public function markAsRead(DatabaseNotification $notification)
    {
        $notification->markAsRead();
    }

    public function markAllRead()
    {
        DatabaseNotification::query()
            ->where('notifiable_type', config('megaphone.model'))
            ->where('notifiable_id', $this->notifiableId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }
}
