<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    //
    public function getAll()
    {
        # code...
        return Auth::user()->notifications;
    }
    public function getUnread()
    {
        # code...
        // foreach (Auth::user()->unreadNotifications as $notification) {
        //     echo $notification;
        // }
        return response()->json(Auth::user()->unreadNotifications);
    }
    public function readNotif()
    {
        # code...
        // foreach (Auth::user()->unreadNotifications as $notification) {
        //     echo $notification;
        // }
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(Auth::user()->unreadNotifications);
    }
    public function clearNotif()
    {
        # code...
       $data = Auth::user()->notifications;

       foreach($data as $notif){
            $notif->delete();
       }
    }
}
