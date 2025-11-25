<?php

namespace MBarlow\Megaphone\Components;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\View\Component;
use MBarlow\Megaphone\Types\BaseAnnouncement;
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

        /** @var BaseAnnouncement $type */
        $type = $this->notification->type;

        $params = [
            'announcement' => array_merge(
                [
                    'title' => '',
                    'body' => '',
                    'link' => '',
                    'linkNewWindow' => false,
                    'linkText' => 'View',
                ],
                $this->notification->data
            ),
            'read_at' => $this->notification->read_at,
            'created_at' => $this->notification->created_at,
            'markAsReadOnClick' => [
                'id' => $this->notification->id,
                'active' => $this->notification->read_at === null &&
                    config('megaphone.links.markAsReadOnClick', false) &&
                    $type::marksAsReadOnLinkClick(),
            ],
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
