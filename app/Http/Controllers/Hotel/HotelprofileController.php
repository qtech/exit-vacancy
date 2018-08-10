<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hoteldata;
use App\User;
use App\Amenities;
use Validator;

class HotelprofileController extends Controller
{
    public function view()
    {
        $getdetails = [
            'details' => User::with('hotel')->where(['role' => 3,'user_id' => Auth()->user()->user_id])->first(),
            'amenities' => Amenities::all()
        ];
        
        return view('hotel_profile.main')->with('getdetails',$getdetails);
    }

    public function update(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'number' => 'required',
                'hotelclass' => 'required',
                'amenities' => 'required'
            ]);
    
            if($validator->fails())
            {
                $response = [
                    'msg' => $validator->errors()->all(),
                    'status' => 0
                ];
            }
            else
            {
                $amenities = implode(",", $request->amenities);

                $update = Hoteldata::where(['user_id' => Auth()->user()->user_id])->first();
                $update->number = $request->number;
                $update->price = $request->price;
                $update->stars = $request->hotelclass;
                $update->amenities = $amenities;
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
