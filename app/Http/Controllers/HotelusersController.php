<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Hoteldata;
use App\Bookings;

class HotelusersController extends Controller
{
    public function view()
    {
        try
        {
            $hotelusers = User::with('hotel','hotelbookings')->where(['role' => 3])->get();
            return view('hotelusers.main')->with('hotelusers', $hotelusers);
        }
        catch(\Exception $e)
        {
            return $e->getMessage." ".$e->getLine();
        }
    }   

    public function hotel_user_details($id)
    {
        try
        {
            $data = [
                'bookings' => Bookings::with('user')->where(['hotel_owner_id' => $id])->get(),
                'hoteluser' => User::with('hotel')->where(['user_id' => $id])->first()
            ];

            return view('hotelusers.hotelprofile')->with($data);
        }
        catch(\Exception $e)
        {
            return $e->getMessage." ".$e->getLine();
        }
    }
}
