<?php

namespace MBarlow\Megaphone\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\Attributes\Locked;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;

class Megaphone extends Component
{
    /**
     * The model that whose notifications should be displayed
     *
     * @var Model
     */
    public ?Model $notifiable = null;

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
        if (empty($this->notifiable) && $request->user() !== null) {
            $this->notifiable = $request->user();
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
        return $this->notifiable;
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

        if(!$this->notifiable) {
            return  <<<HTML
                <div class="flex items-center justify-center h-full">
                    <div class="text-center">
                        <h1 class="text-3xl font-bold text-gray-900">Megaphone</h1>
                        <p class="mt-2 text-sm text-gray-500">Please set the <code>notifiable</code> property on the Megaphone component.</p>
                    </div>
                </div>
            HTML;
        }

        return view('megaphone::megaphone');
    }

    public function markAsRead(DatabaseNotification $notification)
    {
        $notification->markAsRead();
        $this->loadAnnouncements($this->getNotifiable());
    }
}
