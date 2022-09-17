<?php

use MBarlow\Megaphone\Livewire\MegaphoneAdmin;

it('can render the megaphone admin component', function () {
    $this->livewire(MegaphoneAdmin::class)
        ->assertViewIs('megaphone::admin.create-announcement');
});
