<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function fetchNotifications()
    {
        if (auth()->check()) {
            $notifications = auth()->user()->unreadNotifications;

            return response()->json($notifications);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
