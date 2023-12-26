<?php

namespace MBarlow\Megaphone\Http\Controllers;

use Illuminate\Http\Request;
use MBarlow\Megaphone\Models\Notification;

class MegaphonePollController
{

    public function getNotifiable()
    {
        // TODO: This is a hack to get the current user.  It should be passed in as a parameter.

        return auth()->user();
    }

    public function __invoke(Request $request)
    {
        //dd(auth()->user(), $request->user());
        if(!auth()->check()) return abort(403, 'Login required');

        $filterType = request()->get('filter_type');

        $unreadNotifications = $this->getNotifiable()->unreadNotifications->when($filterType, function($query) use($filterType){
            return $query->where('type', $filterType);
        })->pluck('id');
        if($unreadNotifications->count() > 0){
            return response()->json([
                'unread_notifications' => $unreadNotifications
            ]);
        }
        else{
            return response()->json([
                'unread_notifications' => null
            ]);
        }
    }
}
