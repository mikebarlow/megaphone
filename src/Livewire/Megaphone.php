<?php

namespace MBarlow\Megaphone\Livewire;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Megaphone extends Component
{
    public $notifiableId;

    public $announcements;

    public $unread;

    public $showCount;

    /**
     * Whether to poll for new notifications
     *
     * @var boolean|integer
     */
    public bool|int $polling;

    /**
     * How often to poll for new notifications in milliseconds
     *
     * @var string|integer
     */
    public string|int $pollInterval;

    /**
     * Route to handle the AJAX request for polling for new notifications
     *
     * @var string
     */
    #[Locked]
    public string $pollRouteUrl;

    public $rules = [
        'unread' => 'required',
        'announcements' => 'required',
    ];

    protected $listeners = [
        'refreshNotifications' => '$refresh',
    ];

    public function initialize(Request $request)
    {
        if (empty($this->notifiableId) && $request->user() !== null) {
            $this->notifiableId = $request->user()->id;
        }

        $this->loadAnnouncements($this->getNotifiable());
        $this->showCount = config('megaphone.showCount', true);
        $this->polling ??= config('megaphone.defaultPolling');
        $this->pollInterval ??= config('megaphone.defaultPollInterval');
    }

    public function mount(Request $request)
    {
        $this->pollRouteUrl = config('megaphone.pollRouteUrl');
        $this->initialize($request);
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
        $this->initialize(request());
        return view('megaphone::megaphone');
    }

    public function markAsRead(DatabaseNotification $notification)
    {
        $notification->markAsRead();
        $this->loadAnnouncements($this->getNotifiable());
    }
}
