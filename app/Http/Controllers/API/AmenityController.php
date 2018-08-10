<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Amenities;

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
}
