<?php

return [
    /*
     * Model that has the "Notifiable" and "HasMegaphone" Traits
     */
    'model' => \App\Models\User::class,

    /*
     * Array of all the notification types to display in Megaphone
     */
    'types' => [
        \MBarlow\Megaphone\Types\General::class,
        \MBarlow\Megaphone\Types\NewFeature::class,
        \MBarlow\Megaphone\Types\Important::class,
    ],

    /*
     * Custom notification types specific to your App
     */
    'customTypes' => [
        /*
            Associative array in the format of
            \Namespace\To\Notification::class => 'path.to.view',
         */
    ],

    /*
     * Array of Notification types available within MegaphoneAdmin Component or
     * leave as null to show all types / customTypes
     *
     * 'adminTypeList' => [
     *     \MBarlow\Megaphone\Types\NewFeature::class,
     *     \MBarlow\Megaphone\Types\Important::class,
     * ],
     */
    'adminTypeList' => null,

    /*
     * Clear Megaphone notifications older than....
     */
    'clearAfter' => '2 weeks',

    /*
     * Option for setting the icon to show actual count of unread Notifications or
     * show a dot instead
     */
    'showCount' => true,

    /**
     * Default whether to poll for new notifications
     */
    'defaultPolling' => true,

    /**
     * Default how often to poll for new notifications in milliseconds
     */
    'defaultPollInterval' => 2000,

    /**
     * Default Route to handle the AJAX request for polling for new notifications
     * Cannot be changed dynamically.
     */
    'pollRouteUrl' => '/megaphone/poll',

    /**
     * Default Controller action to handle the AJAX request for polling for new notifications
     */
    'pollAction' => \MBarlow\Megaphone\Http\Controllers\MegaphonePollController::class,
];
