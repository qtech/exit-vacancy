<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\RoomAmenity;

class RoomAmenityController extends Controller
{
    public function getData()
    {
        $room_amenity = RoomAmenity::all();
        
        $response = [
            'msg' => 'All the room Amenities',
            'status' => 1,
            'data' => $room_amenity
        ];

        return response()->json($response);
    }

    public function view()
    {
        try
        {
            return view('amenity_room.view');
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(),[
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
            $amenities = implode(",",$request->amenities);
            $amenity = explode(",", $amenities);

            foreach($amenity as $value)
            {
                $new_amenity = new RoomAmenity;
                $new_amenity->name = $value;
                $new_amenity->save();
            }

            $data = RoomAmenity::all();

            $response = [
                'msg' => 'New Room Amenities added',
                'status' => 1,
                'data' => $data
            ];
        }

        return response()->json($response);
    }

    public function disable(Request $request)
    {
        try
        {
            $disable = RoomAmenity::find($request->id);
            $disable->status = $disable->status == 0 ? 1 : 0;
            $disable->save();

            if($disable->status == 1)
            {
                $response = [
                    'msg' => 'Room Amenity Enabled',
                    'status' => 1
                ];
            }
            else
            {
                $response = [
                    'msg' => 'Room Amenity Disabled',
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
