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

    public $allAnnouncementsTypes;

    public $unread;

    public $showCount;

    public bool $showTitleCountInPageTitle = true;

    /**
     * The keys that the annoucements should be have when displayed (serialised from the database and passed to the view)
     * (This is to prevent the entire model being passed to the view)
     * This can be modified to include any additional fields you want to display
     * @var array
     */
    #[Locked]
    public $keys = [
        'id',
        'type',
        // 'read_at',
        // 'created_at',
        // 'updated_at',
    ];


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

        $this->allAnnouncementsTypes = $notifiable->announcements()->select('type')->distinct()->get();

    }

    public function markAsUnread(DatabaseNotification $notification)
    {
        $notification->markAsUnread();
        $this->loadAnnouncements($this->getNotifiable());
    }

    public function findNotification($id)
    {
        return $this->notifiable->announcements()->where('id', $id)->first()->only($this->keys);
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

    public function markAllAsRead()
    {
        $this->notifiable->unreadNotifications->markAsRead();
        $this->loadAnnouncements($this->getNotifiable());
    }
}
