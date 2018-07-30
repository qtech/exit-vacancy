<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hoteldata;
use App\User;
use Validator;

class HotelprofileController extends Controller
{
    public function view()
    {
        $getdetails = User::with('hotel')->where(['role' => 3,'user_id' => Auth()->user()->user_id])->first();
        return view('hotel_profile.main')->with('getdetails', $getdetails);
    }

    public function update(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'number' => 'required',
                'price' => 'required',
                'hotelclass' => 'required'
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
                $update = Hoteldata::where(['user_id' => Auth()->user()->user_id])->first();
                $update->number = $request->number;
                $update->price = $request->price;
                $update->stars = $request->hotelclass;
                $update->save();

                $response = [
                    'msg' => 'Hotel Profile updated',
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
