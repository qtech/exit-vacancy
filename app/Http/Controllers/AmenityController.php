<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Amenities;

class AmenityController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'amenities' => 'required'
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
            $amenities = implode(",",$request->amenities);
            $amenity = explode(",", $amenities);

            foreach($amenity as $value)
            {
                $new_amenity = new Amenities;
                $new_amenity->amenity_name = $value;
                $new_amenity->save();
            }

            $data = Amenities::all();

            $response = [
                'msg' => 'New Amenities added',
                'status' => 1,
                'data' => $data
            ];
        }

        return response()->json($response);
    }
}
