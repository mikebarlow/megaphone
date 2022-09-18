<?php

namespace MBarlow\Megaphone\Livewire;

use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;

class MegaphoneAdmin extends Component
{
    public string $type = '';

    public string $title = '';

    public string $body = '';

    public string $link = '';

    public string $linkText = 'Read More...';

    public array $notifTypes = [];

    public array $users = [];

    public function mount()
    {
        $this->notifTypes = collect(getMegaphoneAdminTypes())
            ->mapWithKeys(
                function ($class) {
                    return [
                        $class => $class::name(),
                    ];
                }
            )
            ->toArray();
    }

    public function render()
    {
        return view('megaphone::admin.create-announcement');
    }

    public function send()
    {
        $this->validate();

        $notification = new $this->type($this->title, $this->body, $this->link, $this->linkText);

        $this->getUsers()->each(
            function ($user) use ($notification) {
                $user->notify($notification);
            }
        );

        session()->flash('megaphone_success', __('Notifications sent successfully!'));
        $this->resetExcept('notifTypes');
    }

    protected function rules()
    {
        return [
            'type' => [
                'required',
                Rule::in(
                    getMegaphoneTypes()
                ),
            ],
            'title' => 'required',
            'body' => 'required',
        ];
    }

    protected function getUsers(): Collection
    {
        $modelClass = config('megaphone.model');

        return (new $modelClass)->get();
    }
}
