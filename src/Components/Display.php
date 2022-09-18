<?php

namespace MBarlow\Megaphone\Components;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\View\Component;
use MBarlow\Megaphone\Types\General;
use MBarlow\Megaphone\Types\Important;
use MBarlow\Megaphone\Types\NewFeature;

class Display extends Component
{
    public DatabaseNotification $notification;

    public function __construct(DatabaseNotification $notification)
    {
        $this->notification = $notification;
    }

    public function render()
    {
        if (! in_array(
            $this->notification->type,
            getMegaphoneTypes()
        )) {
            return '';
        }

        $params = [
            'announcement' => $this->notification->data,
            'read_at' => $this->notification->read_at,
            'created_at' => $this->notification->created_at,
        ];

        $customTypes = config('megaphone.customTypes');

        if (! empty($customTypes[$this->notification->type])) {
            $tpl = $customTypes[$this->notification->type];
        } elseif ($this->notification->type === General::class) {
            $tpl = 'megaphone::types.general';
        } elseif ($this->notification->type === NewFeature::class) {
            $tpl = 'megaphone::types.new-feature';
        } elseif ($this->notification->type === Important::class) {
            $tpl = 'megaphone::types.important';
        } else {
            return '';
        }

        return view(
            $tpl,
            $params
        );
    }
}
