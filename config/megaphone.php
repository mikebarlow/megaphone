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
     * Clear Megaphone notifications older than....
     */
    'clearAfter' => '2 weeks',
];
