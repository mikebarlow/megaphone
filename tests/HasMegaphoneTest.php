<?php

it('can get megaphone only notifications', function () {
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
        \MBarlow\Megaphone\Types\General::class
    );
    $this->createTestNotification(
        $user,
        \MBarlow\Megaphone\Tests\Setup\Types\CustomType::class
    );
    $this->createTestNotification(
        $user,
        \MBarlow\Megaphone\Tests\Setup\Types\SecondCustomType::class
    );

    $this->assertCount(
        2,
        $user->announcements
    );
});

it('can get specific user notifications', function () {
    $user1 = $this->createTestUser();

    $this->actingAs(
        $user2 = $this->createTestUser()
    );

    $this->createTestNotification(
        $user1,
        \MBarlow\Megaphone\Types\General::class
    );
    $this->createTestNotification(
        $user1,
        \MBarlow\Megaphone\Types\General::class
    );
    $this->createTestNotification(
        $user2,
        \MBarlow\Megaphone\Types\General::class
    );

    $this->assertCount(
        1,
        $user2->announcements
    );
});
