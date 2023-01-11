<?php

namespace App\Http\Controllers\Messages;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{


    public function __construct(){

    }

    public function GetUnReadEmailNotifications()
     {
         //$UnreadEmailNotifications = Auth::user()->unreadNotifications;
         $UnreadEmailNotifications  = Notification::where('notifiable_id', Auth::user()->id)
                         ->where('read_at', null)
                         ->where('type', "App\Notifications\NewEmailNotifier")
                         ->get();
    	return $UnreadEmailNotifications;
    }

    public function GetOtherNotifications()
    {
        $UnreadNotifications = Auth::user()->unreadNotifications;
        // Notification::where('notifiable_id', Auth::user()->id)
        // ->where('read_at', null)
        // ->where('type', "App\Notifications\NewEmailNotifier")
        // ->get();
         return $UnreadNotifications;
   }

    public function readNotification(Request $request){
    	Auth::user()->unreadNotifications()->find($request->id)->markAsRead;
    	return back();
    }

		public function markAllRead(){
			$user = Auth::user();
			foreach ($user->unreadNotifications as $notification) {
               $notification->markAsRead();
        }
			return back();
		}
}
