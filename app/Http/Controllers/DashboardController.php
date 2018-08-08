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
            't_users' => User::where(['role' => 2])->whereDate('created_at',today()->format('d'))->count(),
            'm_users' => User::where(['role' => 2])->whereMonth('created_at',today()->format('m'))->count(),
            'hotels' => User::where(['role' => 3])->count(),
            't_hotels' => User::where(['role' => 3])->whereDate('created_at',today()->format('d'))->count(),
            'm_hotels' => User::where(['role' => 3])->whereMonth('created_at',today()->format('m'))->count(),
            'completebookings' => Bookings::where(['status' => 1, 'is_visited' => 1])->count(),
            't_c_bookings' => Bookings::where(['status' => 1, 'is_visited' => 1])->whereDate('created_at',today()->format('d'))->count(),
            'm_c_bookings' => Bookings::where(['status' => 1, 'is_visited' => 1])->whereMonth('created_at',today()->format('m'))->count(),
            'pendingbookings' => Bookings::where(['status' => 1, 'is_visited' => 0])->count(),
            't_p_bookings' => Bookings::where(['status' => 1, 'is_visited' => 0])->whereDate('created_at',today()->format('d'))->count(),
            'm_p_bookings' => Bookings::where(['status' => 1, 'is_visited' => 0])->whereMonth('created_at',today()->format('m'))->count(),
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
