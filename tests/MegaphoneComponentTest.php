<?php

use MBarlow\Megaphone\Livewire\Megaphone;

it('can render the megaphone component with no logged in user', function () {
    $this->livewire(Megaphone::class)
        ->assertViewIs('megaphone::megaphone')
        ->assertSeeHtml($this->bellSvgIcon());
});

it('can render the megaphone component with logged in user', function () {
    $this->actingAs(
        $this->createTestUser()
    );

    $this->livewire(Megaphone::class)
        ->assertViewIs('megaphone::megaphone')
        ->assertSeeHtml($this->bellSvgIcon());
});

it('can render the megaphone component with notification count', function () {
    $this->actingAs(
        $user = $this->createTestUser()
    );

    $this->createTestNotification(
        $user,
        \MBarlow\Megaphone\Types\General::class
    );

    $this->livewire(Megaphone::class)
        ->assertViewIs('megaphone::megaphone')
        ->assertSeeHtml('<span aria-label="unread count" class="absolute top-0 left-0 aspect-square max-h-fit rounded-full border-2 bg-red-500 px-1.5 shadow leading-5 text-white font-semibold text-xs">
                1
            </span>');
});

it('can render the megaphone component with notification dot', function () {
    config()->set(
        'megaphone.showCount', false
    );

    $this->actingAs(
        $user = $this->createTestUser()
    );

    $this->createTestNotification(
        $user,
        \MBarlow\Megaphone\Types\General::class
    );

    $this->livewire(Megaphone::class)
        ->assertViewIs('megaphone::megaphone')
        ->assertSeeHtml('<span aria-label="has unread notifications" class="absolute top-0 left-0 aspect-square h-2/5 rounded-full bg-red-500 shadow">')
        ->assertDontSeeHtml('<span aria-label="unread count" class="absolute top-0 left-0 aspect-square max-h-fit rounded-full border-2 bg-red-500 px-1.5 shadow leading-5 text-white font-semibold text-xs">
                1
            </span>');
});

it('can load announcements', function () {
    $this->actingAs(
        $user = $this->createTestUser()
    );

    $this->createTestNotification(
        $user,
        \MBarlow\Megaphone\Types\General::class
    );
    $this->createTestNotification(
        $user,
        \MBarlow\Megaphone\Types\Important::class
    );
    $user->unreadNotifications->first()->markAsRead();

    $this->livewire(Megaphone::class)
        ->call('loadAnnouncements', $user)
        ->assertSet('unread', $user->unreadNotifications()->get())
        ->assertSet('announcements', $user->readNotifications);
});

it('can mark notification as read', function () {
    $this->actingAs(
        $user = $this->createTestUser()
    );

    $this->createTestNotification(
        $user,
        \MBarlow\Megaphone\Types\General::class
    );
    $this->createTestNotification(
        $user,
        \MBarlow\Megaphone\Types\Important::class
    );
    $notification = $user->unreadNotifications->first();

    $this->livewire(Megaphone::class)
        ->call('markAsRead', $notification)
        ->assertSet('unread', $user->unreadNotifications()->get())
        ->assertSet('announcements', $user->readNotifications);
});

it('can render the megaphone component with general notification', function () {
    $this->actingAs(
        $user = $this->createTestUser()
    );

    $this->createTestNotification(
        $user,
        \MBarlow\Megaphone\Types\General::class
    );

    $this->livewire(Megaphone::class)
        ->assertViewIs('megaphone::megaphone')
        ->assertSeeHtml('<div tabindex="0" aria-label="group icon" role="img" class="focus:outline-none w-8 h-8 border rounded-full border-gray-200 flex flex-shrink-0 items-center justify-center">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="w-4/5 h-4/5 fill-blue-600">
        <path d="M638.4 313.9c-2.1-5.9-6.4-11.2-12.9-14.5-21-10.8-58.3-24.9-87.4-105-.8-2.2-14.7-40.5-15.4-42.6C503 97.6 451.8 64 397.4 64c-15.1 0-30.5 2.6-45.6 8.1-3.6 1.3-6.6 3.3-10 4.8-14.2-16-32.1-29-53.5-36.8-15-5.5-30.5-8.1-45.6-8.1-54.5 0-105.6 33.6-125.3 87.8-.8 2.1-14.6 40.4-15.4 42.6-29.2 80.1-66.4 94.3-87.4 105-6.5 3.3-10.8 8.6-12.9 14.5-4.6 12.9 1 28.8 16 34.2l82 29.9c-2.1 7-3.6 14.3-3.6 22 0 44.2 35.8 80 80 80 32.6 0 60.5-19.6 72.9-47.7l42.1 15.3c-2.8 6.5-7.5 14.8-3.4 26 4.9 13.1 19.6 21.3 34.3 15.9l76-27.7c11.8 29.4 40.5 50.1 74.1 50.1 44.2 0 80-35.8 80-80 0-8.7-1.9-16.8-4.6-24.5l75-27.3c14.9-5.4 20.5-21.3 15.9-34.2zM176 416c-26.5 0-48-21.5-48-48 0-3.9.6-7.5 1.5-11.1l88.9 32.4C210.6 405 194.7 416 176 416zm124.7-30.9L40.1 290.3c24.5-12.8 63.2-38.2 91.8-117 8.3-22.9 5.1-14.1 15.4-42.6C161.9 90.8 200.2 64 242.6 64c44.7 0 70.8 29.1 71.6 29.9-43.3 34.8-62.2 94-42.2 149.1.8 2.1 14.8 40.4 15.6 42.6 16.9 46.4 17.4 77.3 13.1 99.5zM472 448c-19.7 0-36.1-12.2-43.4-29.3l89.3-32.5c1.3 4.4 2.1 9 2.1 13.8 0 26.5-21.5 48-48 48zm-149.5-24.8c10.6-25.6 23.8-69.8-4.8-148.7-9.6-26.3-5.5-15-15.6-42.6-19.1-52.5 8.1-110.8 60.6-129.9 53-19.3 110.9 8.5 129.9 60.6 9.7 26.7 5 13.8 15.4 42.6 28.7 78.8 67.3 104.2 91.8 117l-277.3 101z"/>
    </svg>
</div>');
});

it('can render the megaphone component with important notification', function () {
    $this->actingAs(
        $user = $this->createTestUser()
    );

    $this->createTestNotification(
        $user,
        \MBarlow\Megaphone\Types\Important::class
    );

    $this->livewire(Megaphone::class)
        ->assertViewIs('megaphone::megaphone')
        ->assertSeeHtml('<div tabindex="0" aria-label="group icon" role="img" class="focus:outline-none w-8 h-8 border rounded-full border-gray-200 flex flex-shrink-0 items-center justify-center">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512" class="w-4/5 h-4/5 fill-red-600">
        <path d="M139.315 32c6.889 0 12.364 5.787 11.982 12.666l-14.667 264c-.353 6.359-5.613 11.334-11.982 11.334H67.352c-6.369 0-11.628-4.975-11.982-11.334l-14.667-264C40.321 37.787 45.796 32 52.685 32h86.63M96 352c35.29 0 64 28.71 64 64s-28.71 64-64 64-64-28.71-64-64 28.71-64 64-64M139.315 0h-86.63C27.457 0 7.353 21.246 8.753 46.441l14.667 264c.652 11.728 5.864 22.178 13.854 29.665C14.613 357.682 0 385.168 0 416c0 52.935 43.065 96 96 96s96-43.065 96-96c0-30.832-14.613-58.318-37.274-75.894 7.991-7.487 13.203-17.937 13.854-29.665l14.667-264C184.647 21.251 164.548 0 139.315 0z"/>
    </svg>
</div>');
});

it('can render the megaphone component with new feature notification', function () {
    $this->actingAs(
        $user = $this->createTestUser()
    );

    $this->createTestNotification(
        $user,
        \MBarlow\Megaphone\Types\NewFeature::class
    );

    $this->livewire(Megaphone::class)
        ->assertViewIs('megaphone::megaphone')
        ->assertSeeHtml('<div tabindex="0" aria-label="group icon" role="img" class="focus:outline-none w-8 h-8 border rounded-full border-gray-200 flex flex-shrink-0 items-center justify-center">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="w-4/5 h-4/5 fill-green-600">
        <path d="M544 184.88V32c0-8.74-6.98-32-31.99-32H512c-7.12 0-14.19 2.38-19.98 7.02l-85.03 68.03C364.28 109.19 310.66 128 256 128H64c-35.35 0-64 28.65-64 64v96c0 35.35 28.65 64 64 64l-.48 32c0 39.77 9.26 77.35 25.56 110.94 5.19 10.69 16.52 17.06 28.4 17.06h106.28c26.05 0 41.69-29.84 25.9-50.56-16.4-21.52-26.15-48.36-26.15-77.44 0-11.11 1.62-21.79 4.41-32H256c54.66 0 108.28 18.81 150.98 52.95l85.03 68.03a32.023 32.023 0 0 0 19.98 7.02c24.92 0 32-22.78 32-32V295.12c19.05-11.09 32-31.49 32-55.12.01-23.63-12.94-44.03-31.99-55.12zM223.76 480l-105.89-.03c-14.83-30.56-22.35-62.19-22.36-95.49l.48-32L96 352h99.33c-2.31 10.7-3.81 21.43-3.81 32 0 35.29 11.3 68.78 32.24 96zM64 320c-17.64 0-32-14.36-32-32v-96c0-17.64 14.36-32 32-32h192v160H64zm448.05 126.93c-.04.25-.13.58-.25.9l-84.83-67.87C386.99 348 338.54 328.14 288 322.13V157.87c50.54-6.01 98.99-25.87 138.98-57.84l84.87-67.9c.03.03.06.05.08.05.04 0 .06-.05.07-.17l.05 414.92z"/>
    </svg>
</div>');
});

it('can render the megaphone component with custom notification', function () {
    config()->set(
        'megaphone.customTypes',
        [
            \MBarlow\Megaphone\Tests\Setup\Types\CustomType::class => 'tests::custom-type',
        ]
    );

    $this->actingAs(
        $user = $this->createTestUser()
    );

    $this->createTestNotification(
        $user,
        \MBarlow\Megaphone\Tests\Setup\Types\CustomType::class
    );

    $this->livewire(Megaphone::class)
        ->assertViewIs('megaphone::megaphone')
        ->assertSeeHtml('<div tabindex="0" aria-label="group icon" role="img" class="focus:outline-none w-8 h-8 border rounded-full border-gray-200 flex flex-shrink-0 items-center justify-center">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4/5 h-4/5 fill-red-600">
        <path d="M376 256c0-13.255 10.745-24 24-24s24 10.745 24 24-10.745 24-24 24-24-10.745-24-24zm-40 24c13.255 0 24-10.745 24-24s-10.745-24-24-24-24 10.745-24 24 10.745 24 24 24zm176-128c0 12.296-4.629 23.507-12.232 32 7.603 8.493 12.232 19.704 12.232 32v80c0 12.296-4.629 23.507-12.232 32 7.603 8.493 12.232 19.704 12.232 32v80c0 26.51-21.49 48-48 48H48c-26.51 0-48-21.49-48-48v-80c0-12.296 4.629-23.507 12.232-32C4.629 319.507 0 308.296 0 296v-80c0-12.296 4.629-23.507 12.232-32C4.629 175.507 0 164.296 0 152V72c0-26.51 21.49-48 48-48h416c26.51 0 48 21.49 48 48v80zm-480 0c0 8.822 7.178 16 16 16h416c8.822 0 16-7.178 16-16V72c0-8.822-7.178-16-16-16H48c-8.822 0-16 7.178-16 16v80zm432 48H48c-8.822 0-16 7.178-16 16v80c0 8.822 7.178 16 16 16h416c8.822 0 16-7.178 16-16v-80c0-8.822-7.178-16-16-16zm16 160c0-8.822-7.178-16-16-16H48c-8.822 0-16 7.178-16 16v80c0 8.822 7.178 16 16 16h416c8.822 0 16-7.178 16-16v-80zm-80-224c13.255 0 24-10.745 24-24s-10.745-24-24-24-24 10.745-24 24 10.745 24 24 24zm-64 0c13.255 0 24-10.745 24-24s-10.745-24-24-24-24 10.745-24 24 10.745 24 24 24zm64 240c-13.255 0-24 10.745-24 24s10.745 24 24 24 24-10.745 24-24-10.745-24-24-24zm-64 0c-13.255 0-24 10.745-24 24s10.745 24 24 24 24-10.745 24-24-10.745-24-24-24z"/>
    </svg>
</div>');
});

it('can handle custom megaphone notification types with no template set', function () {
    config()->set(
        'megaphone.customTypes',
        [
            \MBarlow\Megaphone\Tests\Setup\Types\CustomType::class => '',
        ]
    );

    $this->actingAs(
        $user = $this->createTestUser()
    );

    $this->createTestNotification(
        $user,
        \MBarlow\Megaphone\Tests\Setup\Types\CustomType::class
    );

    $this->livewire(Megaphone::class)
        ->assertViewIs('megaphone::megaphone')
        ->assertDontSeeHtml('<div tabindex="0" aria-label="group icon" role="img" class="focus:outline-none w-8 h-8 border rounded-full border-gray-200 flex flex-shrink-0 items-center justify-center">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4/5 h-4/5 fill-red-600">
        <path d="M376 256c0-13.255 10.745-24 24-24s24 10.745 24 24-10.745 24-24 24-24-10.745-24-24zm-40 24c13.255 0 24-10.745 24-24s-10.745-24-24-24-24 10.745-24 24 10.745 24 24 24zm176-128c0 12.296-4.629 23.507-12.232 32 7.603 8.493 12.232 19.704 12.232 32v80c0 12.296-4.629 23.507-12.232 32 7.603 8.493 12.232 19.704 12.232 32v80c0 26.51-21.49 48-48 48H48c-26.51 0-48-21.49-48-48v-80c0-12.296 4.629-23.507 12.232-32C4.629 319.507 0 308.296 0 296v-80c0-12.296 4.629-23.507 12.232-32C4.629 175.507 0 164.296 0 152V72c0-26.51 21.49-48 48-48h416c26.51 0 48 21.49 48 48v80zm-480 0c0 8.822 7.178 16 16 16h416c8.822 0 16-7.178 16-16V72c0-8.822-7.178-16-16-16H48c-8.822 0-16 7.178-16 16v80zm432 48H48c-8.822 0-16 7.178-16 16v80c0 8.822 7.178 16 16 16h416c8.822 0 16-7.178 16-16v-80c0-8.822-7.178-16-16-16zm16 160c0-8.822-7.178-16-16-16H48c-8.822 0-16 7.178-16 16v80c0 8.822 7.178 16 16 16h416c8.822 0 16-7.178 16-16v-80zm-80-224c13.255 0 24-10.745 24-24s-10.745-24-24-24-24 10.745-24 24 10.745 24 24 24zm-64 0c13.255 0 24-10.745 24-24s-10.745-24-24-24-24 10.745-24 24 10.745 24 24 24zm64 240c-13.255 0-24 10.745-24 24s10.745 24 24 24 24-10.745 24-24-10.745-24-24-24zm-64 0c-13.255 0-24 10.745-24 24s10.745 24 24 24 24-10.745 24-24-10.745-24-24-24z"/>
    </svg>
</div>');
});

it('can handle invalid megaphone notification type', function () {
    config()->set(
        'megaphone.customTypes',
        [
            \MBarlow\Megaphone\Tests\Setup\Types\CustomType::class => '',
        ]
    );

    $this->actingAs(
        $user = $this->createTestUser()
    );

    $this->createTestNotification(
        $user,
        \MBarlow\Megaphone\Tests\Setup\Types\CustomType::class
    );

    $announcements = $user->announcements()->get();

    config()->set(
        'megaphone.customTypes',
        []
    );

    $this->livewire(Megaphone::class)
        ->set('unread', $announcements->whereNull('read_at'))
        ->set('announcements', $announcements->whereNotNull('read_at'))
        ->assertViewIs('megaphone::megaphone')
        ->assertDontSeeHtml('<div tabindex="0" aria-label="group icon" role="img" class="focus:outline-none w-8 h-8 border rounded-full border-gray-200 flex flex-shrink-0 items-center justify-center">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4/5 h-4/5 fill-red-600">
        <path d="M376 256c0-13.255 10.745-24 24-24s24 10.745 24 24-10.745 24-24 24-24-10.745-24-24zm-40 24c13.255 0 24-10.745 24-24s-10.745-24-24-24-24 10.745-24 24 10.745 24 24 24zm176-128c0 12.296-4.629 23.507-12.232 32 7.603 8.493 12.232 19.704 12.232 32v80c0 12.296-4.629 23.507-12.232 32 7.603 8.493 12.232 19.704 12.232 32v80c0 26.51-21.49 48-48 48H48c-26.51 0-48-21.49-48-48v-80c0-12.296 4.629-23.507 12.232-32C4.629 319.507 0 308.296 0 296v-80c0-12.296 4.629-23.507 12.232-32C4.629 175.507 0 164.296 0 152V72c0-26.51 21.49-48 48-48h416c26.51 0 48 21.49 48 48v80zm-480 0c0 8.822 7.178 16 16 16h416c8.822 0 16-7.178 16-16V72c0-8.822-7.178-16-16-16H48c-8.822 0-16 7.178-16 16v80zm432 48H48c-8.822 0-16 7.178-16 16v80c0 8.822 7.178 16 16 16h416c8.822 0 16-7.178 16-16v-80c0-8.822-7.178-16-16-16zm16 160c0-8.822-7.178-16-16-16H48c-8.822 0-16 7.178-16 16v80c0 8.822 7.178 16 16 16h416c8.822 0 16-7.178 16-16v-80zm-80-224c13.255 0 24-10.745 24-24s-10.745-24-24-24-24 10.745-24 24 10.745 24 24 24zm-64 0c13.255 0 24-10.745 24-24s-10.745-24-24-24-24 10.745-24 24 10.745 24 24 24zm64 240c-13.255 0-24 10.745-24 24s10.745 24 24 24 24-10.745 24-24-10.745-24-24-24zm-64 0c-13.255 0-24 10.745-24 24s10.745 24 24 24 24-10.745 24-24-10.745-24-24-24z"/>
    </svg>
</div>');
});
