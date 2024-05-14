<?php

namespace App\Http\Controllers\StoreManager;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Illuminate\Notifications\DatabaseNotification;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index()
    {
        return Inertia::render('StoreManager/Notifications', [
            'notifications' => NotificationResource::collection(auth()->user()->notifications()->paginate(10))
        ]);
    }

    public function markAsRead(DatabaseNotification $notification)
    {
        $notification->markAsRead();
        return redirect()->back();
    }

    public function markAsUnread(DatabaseNotification $notification)
    {
        $notification->markAsUnread();
        return redirect()->back();
    }

    public function delete()
    {
        auth()->user()->notifications()->whereNotNull('read_at')->delete();
        return redirect()->back();
    }

    public function getCount()
    {
        return auth()->user()->unreadNotifications()->count();
    }

    public function getNotifications()
    {
        return NotificationResource::collection(auth()->user()->notifications()->paginate(10));
    }
}
