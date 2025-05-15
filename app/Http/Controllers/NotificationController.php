<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function unread()
    {
        $notifications = auth()->user()->notifications()
            ->whereNull('read_at')
            ->latest()
            ->take(10)
            ->get();

        return response()->json($notifications);
    }

}
