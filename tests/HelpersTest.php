<?php

it('can get megaphone types from config', function () {
    $this->assertEquals(
        [
            \MBarlow\Megaphone\Types\General::class,
            \MBarlow\Megaphone\Types\NewFeature::class,
            \MBarlow\Megaphone\Types\Important::class,
        ],
        getMegaphoneTypes()
    );
});

it('can merge default and custom megaphone types from config', function () {
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
        getMegaphoneTypes()
    );
});

it('can fallback to getMegaphoneTypes if adminTypeList is null', function () {
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
        getMegaphoneAdminTypes()
    );
});

it('can get the custom adminTypeList if an array', function () {
    config()->set(
        'megaphone.adminTypeList',
        [
            \MBarlow\Megaphone\Types\NewFeature::class,
            \MBarlow\Megaphone\Types\Important::class,
        ]
    );

    $this->assertEquals(
        [
            \MBarlow\Megaphone\Types\NewFeature::class,
            \MBarlow\Megaphone\Types\Important::class,
        ],
        getMegaphoneAdminTypes()
    );
});
