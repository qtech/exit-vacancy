<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Amenities;
use App\Hoteldata;
use App\RoomAmenity;

class AmenityController extends Controller
{
    public function getAmenities()
    {
        try
        {
            $amenities = Amenities::where(['status' => 1])->get();
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
            if($request->amenities != NULL)
            {
                $amenity = Hoteldata::where(['hotel_data_id' => $request->hotel_id, 'user_id' => $request->hotel_owner_id])->first();
                $amenity->amenities = $request->amenities;
                $amenity->save();
    
                $response = [
                    'msg' => 'Your custom amenities successfully added',
                    'status' => 1
                ];
            }
            else
            {
                $response = [
                    'msg' => 'Please add atleast some one amenity',
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

    // ROOM AMENITY

    public function getRoomAmenities()
    {
        try
        {
            $amenities = RoomAmenity::where(['status' => 1])->get();
            $data = [];

            foreach($amenities as $value)
            {   
                $tmp = [
                    'room_amenity_id' => $value->room_amenity_id,
                    'room_amenity_name' => $value->name
                ];

                array_push($data, $tmp);
            }

            $response = [
                'msg' => "List of Room Amenities",
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
}
