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

    public function hotel_booking_chart(Request $request)
    {
        try
        {
            if($request->id)
            {
                $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'), DB::raw('status'), DB::raw('is_visited'))->where(['hotel_owner_id' => $request->id])->groupBy('date')->get();
            
                $dateLabel = ["2018-07-23","2018-07-26"];
                $completed = [2,6];
                $pending = [0,2];
                $cancelled = [1,3];

                foreach($bookings as $value)
                {
                    if($value->status == 1)
                    {
                        if($value->is_visited == 1)
                        {
                            array_push($dateLabel,$value->date);
                            array_push($completed,$value->count);
                            array_push($pending,0);
                            array_push($cancelled,0);
                        }
                        else
                        {
                            array_push($dateLabel,$value->date);
                            array_push($pending,$value->count);
                            array_push($completed,0);
                            array_push($cancelled,0);
                        }
                    }
                    else
                    {
                        array_push($dateLabel,$value->date);
                        array_push($cancelled,$value->count);
                        array_push($completed,0);
                        array_push($pending,0);
                    }
                }

                $response = [
                    'msg' => 'Hotel Bookings',
                    'status' => 1,
                    'completed' => $completed,
                    'pending' => $pending,
                    'cancelled' => $cancelled,
                    'dateLabel' => $dateLabel
                ];
            }
            else
            {
                $response = [
                    'msg' => 'Invalid Parameters',
                    'status' => 0
                ];
            }
        }
        catch(\Exception $e)
        {
            $response = [
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
                'status' => 0
            ];
        }
        return response()->json($response);
    }
}
