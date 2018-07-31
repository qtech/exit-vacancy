<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;

class HotelamenityController extends Controller
{
    public function view()
    {
        try
        {
            $amenity = User::find(1);
            return view('amenities.main')->with('amenity', $amenity);
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }

    public function update(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'amenity' => 'required'
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
                $amenity = User::where(['user_id' => 1])->first();
                $amenity->lname = $request->amenity;
                $amenity->save();

                $response = [
                    'msg' => 'Hotel Amenities updated',
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
