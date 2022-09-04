<?php

namespace MBarlow\Megaphone\Livewire;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Livewire\Component;
use MBarlow\Megaphone\Types\General;

class MegaphoneAdmin extends Component
{
    public string $type = '';
    public string $title = '';
    public string $body = '';
    public string $link = '';
    public string $linkText = 'Read More...';
    public array $notifTypes = [];

    public array $users = [];

    public function mount(Request $request)
    {
        $this->notifTypes = collect(
            array_merge(
                (array) config('megaphone.types', []),
                array_keys((array) config('megaphone.customTypes', []))
            )
        )->mapWithKeys(
            function ($class) {
                return [
                    $class => $class::name(),
                ];
            }
        )->toArray();
    }

    public function render()
    {
        return view('megaphone::admin.create-announcement');
    }

    public function send()
    {
        $this->validate();

        $notification = new $this->type($this->title, $this->body, $this->link, $this->linkText);

        dump($notification);

    }

    protected function rules()
    {
        return [
            'type' => [
                'required',
                Rule::in(config('megaphone.types', [])),
            ],
            'title' => 'required',
            'body'  => 'required',
        ];
    }
}
