<?php

namespace MBarlow\Megaphone\Types;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class BaseAnnouncement extends Notification
{
    use Queueable;

    public function __construct($title, $body, $link = '', $linkText = '')
    {
        $this->title = $title;
        $this->body = $body;
        $this->link = $link;
        $this->linkText = $linkText;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'link' => $this->link,
            'linkText' => $this->linkText,
        ];
    }

    public static function name(): string
    {
        $elements = explode('\\', static::class);
        $class = end($elements);

        return implode(' ', Str::ucsplit($class));
    }
}
