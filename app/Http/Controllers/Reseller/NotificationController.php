<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        // $notifications = auth('reseller')->user()->notifications->groupBy(function($item) {
        //     return $item->created_at->format('F j, Y');
        // });
        $notifications = auth('reseller')->user()->notifications()->simplePaginate(10);

        return view('reseller.notifications.index', compact('notifications'));
    }

    public function update(Request $request, ?DatabaseNotification $notification = null)
    {
        if ($notification?->getKey()) {
            $notification->markAsRead();
        } else {
            auth('reseller')->user()->notifications->markAsRead();
        }

        return redirect()->back();
    }

    public function destroy(Request $request, ?DatabaseNotification $notification = null)
    {
        if ($notification?->getKey()) {
            $notification->delete();
        } elseif ($request->delete) {
            $reseller = auth('reseller')->user();
            switch ($request->delete) {
                case 'unread':
                    $reseller->unreadNotifications()->delete();
                    break;

                case 'raed':
                    $reseller->readNotifications()->delete();
                    break;
            }
        } else {
            auth('reseller')->user()->notifications()->delete();
        }

        return redirect()->back();
    }
}
