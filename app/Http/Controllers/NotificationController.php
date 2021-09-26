<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function markReadAll()
    {
        $notifications = Auth::user()->unreadNotifications;
        if ($notifications) {

            foreach ($notifications as $notification) {

                $notification->markAsRead();
            }
        }

        session()->flash('readAll', 'تم تعيين كل الإشعارات كمقروؤة');
        return redirect()->route('home');
    }

    public function markRead($id)
    {
        $notifications = Auth::user()->unreadNotifications;

        foreach($notifications as $notification){
            if($notification['data']['id'] == $id){
                 $notification->markAsRead();
            }
        }
        


       



        session()->flash('read', 'تم تعيين الإشعار كمقروء');
        return redirect()->route('home');
    }
}
