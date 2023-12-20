<?php

namespace MBarlow\Megaphone\Http\Controllers;

use App\Http\Controllers\Controller;

class MegaphonePollController extends Controller
{
    public $notifiable;

    public function __invoke()
    {

        /**
         * Get the $notifiable model from the request
         */

        // Verify CSRF token
        if(!request()->header('X-CSRF-TOKEN') || !hash_equals(request()->header('X-CSRF-TOKEN'), csrf_token())) {
            return response()->json([
                ['error' => 'Invalid CSRF token']
            ])->setStatusCode(401);
        }

        // Verify logged in
        if(!auth()->check()) return response()->json([
            ['error' => 'Not logged in']
        ])->setStatusCode(401);

        // Verify notifiable
        if(!request()->get('notifiable')) return response()->json([
            ['error' => 'No notifiable']
        ])->setStatusCode(400);

        $notifiableProps = json_decode(base64_decode(request()->get('notifiable')), true);

        // Verify notifiable model and id
        if(!isset($notifiableProps['model']) || !isset($notifiableProps['id'])) {
            return response()->json([
                ['error' => 'Invalid notifiable']
            ])->setStatusCode(400);
        }

        $this->notifiable =  $notifiableProps['model']::find($notifiableProps['id']);

        /**
         * Access the notification
         */
        if(
            !$this->notifiable ||
            !auth()->user()->canAccessNotifications($this->notifiable)
        ) {
            return response()->json(
                ['error' => 'Not authorized or notifiable not found'] // Joining these two errors for security reasons (to prevent user/model enumeration)
            )->setStatusCode(401);
        }
        $unreadNotifications = $this->notifiable->unreadNotifications->pluck('id');
        return response()->json([
            'data' => [
                'unread_notifications' => $unreadNotifications
            ]
        ]);
    }
}
