<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hoteldata;

class RoomsController extends Controller
{
    public function getRoomdetails(Request $request)
    {
        try
        {
            $room = Hoteldata::where(['user_id' => $request->hotel_id])->first();

            $data = [
                [
                    'room_type' => "King Size Room",
                    'room_available' => $room->king_room,
                    'room_image' => ($room->king_room_image != NULL) ? url("/")."/".$room->king_room_image : "",
                    'room_price' => $room->king_room_price,
                    'room_amenity' => ($room->king_room_amenity != NULL) ? $room->king_room_amenity : ""
                ],
                [
                    'room_type' => "Queen Size Room",
                    'room_available' => $room->queen_room,
                    'room_image' => ($room->queen_room_image != NULL) ? url("/")."/".$room->queen_room_image : "",
                    'room_price' => $room->queen_room_price,
                    'room_amenity' => ($room->queen_room_amenity != NULL) ? $room->queen_room_amenity : ""
                ]
            ];

            $response = [
                'msg' => 'Available room details',
                'status' => 1,
                'data' => $data
            ];
        }
        catch(\Exception $e)
        {
            $response =  [
                'msg' => $e->getMessage()." ".$e->getLine(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }

    public function update_kingRoom(Request $request)
    {
        try
        {
            $room = Hoteldata::where(['user_id' => $request->hotel_id])->first();

            $room->king_room = $request->room_available;
            $room->king_room_price = $request->room_price;
            $room->king_room_amenity = $request->room_amenity;
            $room->save();

            $response = [
                'msg' => 'Room details successfully updated',
                'status' => 1
            ];
        }
        catch(\Exception $e)
        {
            $response =  [
                'msg' => $e->getMessage()." ".$e->getLine(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }

    public function update_queenRoom(Request $request)
    {
        try
        {
            $room = Hoteldata::where(['user_id' => $request->hotel_id])->first();

            $room->queen_room = $request->room_available;
            $room->queen_room_price = $request->room_price;
            $room->queen_room_amenity = $request->room_amenity;
            $room->save();

            $response = [
                'msg' => 'Room details successfully updated',
                'status' => 1
            ];
        }
        catch(\Exception $e)
        {
            $response =  [
                'msg' => $e->getMessage()." ".$e->getLine(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }
}
