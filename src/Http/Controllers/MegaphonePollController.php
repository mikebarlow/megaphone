<?php

namespace MBarlow\Megaphone\Http\Controllers;

class MegaphonePollController
{

    public function getNotifiable()
    {
        if(!auth()->check()) return abort(403, 'Login required');

        // TODO: This is a hack to get the current user.  It should be passed in as a parameter.
        // However, simply passing it as a parameter would lead to a security hole, as the user could
        // pass in any user ID they wanted.  So, we need to pass in the user ID and then check that
        // the user ID matches the current user, or at least that the current user has permission
        // to view the notifications for the user ID passed in.
        return auth()->user();
    }

    public function __invoke()
    {
        $unreadNotifications = $this->getNotifiable()->unreadNotifications->pluck('id');
        return response()->json([
            'unread_notifications' => $unreadNotifications->count() ? $unreadNotifications : null
        ]);
    }
}
