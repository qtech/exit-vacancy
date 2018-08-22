<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Amenities;
use App\Hoteldata;

class AmenityController extends Controller
{
    public function getAmenities()
    {
        try
        {
            $amenities = Amenities::all();
            $data = [];

            foreach($amenities as $value)
            {   
                $tmp = [
                    'amenity_id' => $value->amenity_id,
                    'amenity_name' => $value->amenity_name
                ];

                array_push($data, $tmp);
            }

            $response = [
                'msg' => "List of Amenities",
                'status' => 1,
                'data' => $data
            ];
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

    public function get_custom_amenities(Request $request)
    {
        try
        {
            $amenity = Hoteldata::where(['hotel_data_id' => $request->hotel_id, 'user_id' => $request->hotel_owner_id])->first();

            $amenities = explode(",",$amenity->amenities);

            $response = [
                'msg' => 'Hotel amenities',
                'status' => 1,
                'amenities' => $amenities
            ];
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

    public function update_custom_amenities(Request $request)
    {
        try
        {
            $amenity = Hoteldata::where(['hotel_data_id' => $request->hotel_id, 'user_id' => $request->hotel_owner_id])->first();
            $amenity->amenities = $request->amenities;
            $amenity->save();

            $response = [
                'msg' => 'Your custom amenities successfully added',
                'status' => 1
            ];
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
