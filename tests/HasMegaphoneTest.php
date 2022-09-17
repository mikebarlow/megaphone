<?php

it('can get megaphone types from config', function () {
    $user = $this->createTestUser();

    $this->assertEquals(
        [
            \MBarlow\Megaphone\Types\General::class,
            \MBarlow\Megaphone\Types\NewFeature::class,
            \MBarlow\Megaphone\Types\Important::class,
        ],
        $user->getMegaphoneTypes()
    );
});

it('can merge default and custom megaphone types from config', function () {
    $user = $this->createTestUser();
    config()->set(
        'megaphone.customTypes',
        [
            \MBarlow\Megaphone\Tests\Setup\Types\CustomType::class => 'tests::custom-type',
        ]
    );

    $this->assertEquals(
        [
            \MBarlow\Megaphone\Types\General::class,
            \MBarlow\Megaphone\Types\NewFeature::class,
            \MBarlow\Megaphone\Types\Important::class,
            \MBarlow\Megaphone\Tests\Setup\Types\CustomType::class,
        ],
        $user->getMegaphoneTypes()
    );
});

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

it('can get only its notifications', function () {
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
