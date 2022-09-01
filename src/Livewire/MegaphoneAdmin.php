<?php

namespace MBarlow\Megaphone\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;

class MegaphoneAdmin extends Component
{
    public string $title;
    public string $body;
    public string $link;
    public string $linkText;
    public array $types = [];
    public array $recipients = [];

    public array $users = [];

    public function mount(Request $request)
    {
        $this->types = array_merge(
            (array) config('megaphone.types', []),
            array_keys((array) config('megaphone.customTypes', []))
        );


    }

    public function render()
    {
        return view('megaphone::admin.create-announcement');
    }
}
