<?php

namespace App\Http\Controllers;

use Auth;

class ReadNotificationController extends Controller
{
    public function update($notification)
    {
        Auth::user()->unreadNotifications()->find($notification)->markAsRead();
    }
}
