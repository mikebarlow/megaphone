<?php

use Carbon\Carbon;

it('can render clear out old notifications', function () {
    $user = $this->createTestUser();

    $this->createTestNotification(
        $user,
        \MBarlow\Megaphone\Types\General::class
    );
    $this->assertDatabaseCount('notifications', 1);
    $user->unreadNotifications->markAsRead();

    Carbon::setTestNow(
        Carbon::now()->addWeeks(3)
    );

    $this->artisan('megaphone:clear-announcements')->assertSuccessful();

    $this->assertDatabaseCount('notifications', 0);
});

it('wont clear newer read notification', function () {
    $user = $this->createTestUser();

    $this->createTestNotification(
        $user,
        \MBarlow\Megaphone\Types\General::class
    );
    $this->assertDatabaseCount('notifications', 1);
    $user->unreadNotifications->markAsRead();

    Carbon::setTestNow(
        Carbon::now()->addWeeks(1)
    );

    $this->artisan('megaphone:clear-announcements')->assertSuccessful();

    $this->assertDatabaseCount('notifications', 1);
});

it('wont clear unread notification', function () {
    $user = $this->createTestUser();

    $this->createTestNotification(
        $user,
        \MBarlow\Megaphone\Types\General::class
    );
    $this->assertDatabaseCount('notifications', 1);

    Carbon::setTestNow(
        Carbon::now()->addWeeks(3)
    );

    $this->artisan('megaphone:clear-announcements')->assertSuccessful();

    $this->assertDatabaseCount('notifications', 1);
});
