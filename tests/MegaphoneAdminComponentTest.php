<?php

use Livewire\Livewire;
use MBarlow\Megaphone\Livewire\Admin;

it('can render the megaphone admin component', function () {
    Livewire::test(Admin::class)
        ->assertViewIs('megaphone::admin.create-announcement');
});

it('can send notifications to users', function () {
    $this->createTestUser();
    $this->createTestUser();

    Livewire::test(Admin::class)
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

    Livewire::test(Admin::class)
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

    Livewire::test(Admin::class)
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
    Livewire::test(Admin::class)
        ->set('type', \MBarlow\Megaphone\Types\General::class)
        ->call('send')
        ->assertHasErrors(['title', 'body']);
});

it('fails validation when invalid / unregistered type set', function () {
    Livewire::test(Admin::class)
        ->set('type', \MBarlow\Megaphone\Tests\Setup\Types\CustomType::class)
        ->set('title', 'Test Notification')
        ->set('body', 'This is a test notification')
        ->call('send')
        ->assertHasErrors(['type',]);
});