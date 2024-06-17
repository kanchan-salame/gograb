<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Events\SendNotification;
use App\Models\User;
use App\Notifications\PusherNotification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Notification/Index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function sendNotification(Request $request)
    {
        $users = User::where('role', $request['user_type'])->get();
        foreach ($users as $key => $user) {
            $user->notify(new PusherNotification($user->id , $request['comment']));
        }
    }

    public function unreadNotification() {
        if (auth()->user()) {
            $unreadNotifications = auth()->user()->unreadNotifications;
            return response()->json($unreadNotifications);
        }

    }

    public function markAllAsRead() {
        auth()->user()->notifications->markAsRead();
        return response()->json('success');
    }

    public function showNotification($id) {
        $notification = Notification::where('id', $id)->get();

        if ($id) {
            Auth::user()->unreadNotifications->where('id', $id)->markAsRead();
        }

        return response()->json('success');
    }
}
