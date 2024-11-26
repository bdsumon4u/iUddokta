<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        // $notifications = auth()->user()->notifications->groupBy(function($item) {
        //     return $item->created_at->format('F j, Y');
        // });
        $notifications = auth()->user()->notifications()->simplePaginate(10);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function update(Request $request, ?DatabaseNotification $notification)
    {
        if ($notification->getKey()) {
            $notification->markAsRead();
        } else {
            auth()->user()->notifications->markAsRead();
        }

        return redirect()->back();
    }

    public function destroy(Request $request, ?DatabaseNotification $notification)
    {
        if ($notification->getKey()) {
            $notification->delete();
        } elseif ($request->delete) {
            $admin = auth()->user();
            switch ($request->delete) {
                case 'unread':
                    $admin->unreadNotifications()->delete();
                    break;

                case 'raed':
                    $admin->readNotifications()->delete();
                    break;
            }
        } else {
            auth()->user()->notifications()->delete();
        }

        return redirect()->back();
    }
}
