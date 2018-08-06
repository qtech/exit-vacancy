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
        // $user = DB::table('users')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
        //         ->groupBy('date')
        //         ->get();
        $data = [
            'users' => User::where(['role' => 2])->count(),
            'hotels' => User::where(['role' => 3])->count(),
            'bookings' => Bookings::where(['status' => 1])->count(),
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
}
