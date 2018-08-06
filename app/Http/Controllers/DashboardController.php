<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Hoteldata;
use App\Bookings;
use App\Notifications;
use App\Amenities;
use DB;


class DashboardController extends Controller
{
    public function view()
    {  
        $data = [
            'users' => User::where(['role' => 2])->count(),
            'hotels' => User::where(['role' => 3])->count(),
            'completebookings' => Bookings::where(['status' => 1])->count(),
            'cancelbookings' => Bookings::where(['status' => 2])->count(),
            'mails' => Notifications::where(['type' => 2, 'status' => 1])->count(),
            'hmails' => Notifications::where(['type' => 2, 'status' => 2])->count(),
            'sms' => Notifications::where(['type' => 3, 'status' => 1])->count(),
            'hsms' => Notifications::where(['type' => 3, 'status' => 2])->count(),
            'notifications' => Notifications::where(['type' => 1, 'status' => 1])->count(),
            'hnotifications' => Notifications::where(['type' => 1, 'status' => 2])->count(),
            'amenities' => Amenities::where(['status' => 1])->count()
        ];
        
        return view('dashboard.main')->with($data);
    }

    public function viewhoteldashboard()
    {
        $data = [
            'accepted' => Bookings::where(['hotel_owner_id' => Auth()->user()->user_id,'status' => 1])->count(),
            'declined' => Bookings::where(['hotel_owner_id' => Auth()->user()->user_id,'status' => 2])->count(),
            'rooms' => Hoteldata::where(['user_id' => Auth()->user()->user_id])->first()
        ];

        return view('dashboard.main')->with($data);
    }
}
