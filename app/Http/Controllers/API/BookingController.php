<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;
use App\Bookings;

class BookingController extends Controller
{
    public function storeBooking(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'user_id' => 'required',
                'hotel_id' => 'required'
            ]);

            if($validator->fails())
            {
                $response = [
                    'msg' => 'Oops! Some field is missing',
                    'status' => 0
                ];
            }
            else
            {
                $booking = new Bookings;
                $booking->user_id = $request->user_id;
                $booking->hotel_id = $request->hotel_id;
                $booking->save();

                $response = [
                    'msg' => 'Booking successful',
                    'status' => 1
                ];
            }
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
}
