<?php

use MBarlow\Megaphone\Livewire\MegaphoneAdmin;

it('can render the megaphone admin component', function () {
    $this->livewire(MegaphoneAdmin::class)
        ->assertViewIs('megaphone::admin.create-announcement');
});

it('can send notifications to users', function () {
    $this->createTestUser();
    $this->createTestUser();

    $this->livewire(MegaphoneAdmin::class)
        ->set('type', \MBarlow\Megaphone\Types\General::class)
        ->set('title', 'Test Notification')
        ->set('body', 'This is a test notification')
        ->call('send')
        ->assertSee('Notifications sent successfully!');

    $this->assertDatabaseCount('notifications', 2);
});

it('can send notifications to users with custom type', function () {
    $this->createTestUser();
    $this->createTestUser();

    config()->set(
        'megaphone.customTypes',
        [
            \MBarlow\Megaphone\Tests\Setup\Types\CustomType::class => 'tests::custom-type',
        ]
    );

    $this->livewire(MegaphoneAdmin::class)
        ->set('type', \MBarlow\Megaphone\Tests\Setup\Types\CustomType::class)
        ->set('title', 'Test Notification')
        ->set('body', 'This is a test notification')
        ->call('send')
        ->assertSee('Notifications sent successfully!');

    $this->assertDatabaseCount('notifications', 2);
});


it('can send notifications to user with link', function () {
    $this->createTestUser();
    $this->createTestUser();

    $this->livewire(MegaphoneAdmin::class)
        ->set('type', \MBarlow\Megaphone\Types\General::class)
        ->set('title', 'Test Notification')
        ->set('body', 'This is a test notification')
        ->set('link', 'https://github.com/mbarlow')
        ->set('linkText', 'My Github Profile')
        ->call('send')
        ->assertSee('Notifications sent successfully!');

    $this->assertDatabaseCount('notifications', 2);
});

it('fails validation when no title or body set', function () {
    $this->livewire(MegaphoneAdmin::class)
        ->set('type', \MBarlow\Megaphone\Types\General::class)
        ->call('send')
        ->assertHasErrors(['title', 'body']);
});

it('fails validation when invalid / unregistered type set', function () {
    $this->livewire(MegaphoneAdmin::class)
        ->set('type', \MBarlow\Megaphone\Tests\Setup\Types\CustomType::class)
        ->set('title', 'Test Notification')
        ->set('body', 'This is a test notification')
        ->call('send')
        ->assertHasErrors(['type',]);
});
