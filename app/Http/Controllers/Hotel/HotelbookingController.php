<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Hoteldata;
use App\Bookings;
use Validator;

class HotelbookingController extends Controller
{
    public function view()
    {
        try
        {
            $getdetails = Bookings::with('customer','user')->where(['hotel_owner_id' => Auth()->user()->user_id])->get();
            return view('hotel_booking.main')->with('getdetails', $getdetails);
        }
        catch(\Exception $e)
        {
            $response = [
                'msg' => $e->getMessage()." ".$e->getLine(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }

    public function delete($id)
    {
        $delete = Bookings::find($id)->delete();
        return redirect()->route('hotelbookings')->with('success', 'Booking deleted successfully');
    }
}
