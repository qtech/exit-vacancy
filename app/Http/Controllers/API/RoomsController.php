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
                    'room_type' => "Standard Room",
                    'room_available' => $room->standard_room,
                    'room_image' => ($room->standard_room_image != NULL) ? url("/")."/".$room->standard_room_image : "",
                    'room_price' => $room->standard_room_price,
                    'room_amenity' => ($room->standard_room_amenity != NULL) ? $room->standard_room_amenity : ""
                ],
                [
                    'room_type' => "Deluxe",
                    'room_available' => $room->deluxe_room,
                    'room_image' => ($room->deluxe_room_image != NULL) ? url("/")."/".$room->deluxe_room_image : "",
                    'room_price' => $room->deluxe_room_price,
                    'room_amenity' => ($room->deluxe_room_amenity != NULL) ? $room->deluxe_room_amenity : ""
                ],
                [
                    'room_type' => "Super Deluxe",
                    'room_available' => $room->superdeluxe_room,
                    'room_image' => ($room->superdeluxe_room_image != NULL) ? url("/")."/".$room->superdeluxe_room_image : "",
                    'room_price' => $room->superdeluxe_room_price,
                    'room_amenity' => ($room->superdeluxe_room_amenity != NULL) ? $room->superdeluxe_room_amenity : "" 
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

    public function update_standardRoom(Request $request)
    {
        try
        {
            $room = Hoteldata::where(['user_id' => $request->hotel_id])->first();

            $room->standard_room = $request->room_available;
            $room->standard_room_price = $request->room_price;
            $room->standard_room_amenity = $request->room_amenity;
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

    public function update_deluxeRoom(Request $request)
    {
        try
        {
            $room = Hoteldata::where(['user_id' => $request->hotel_id])->first();

            $room->deluxe_room = $request->room_available;
            $room->deluxe_room_price = $request->room_price;
            $room->deluxe_room_amenity = $request->room_amenity;
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

    public function update_superdeluxeRoom(Request $request)
    {
        try
        {
            $room = Hoteldata::where(['user_id' => $request->hotel_id])->first();

            $room->superdeluxe_room = $request->room_available;
            $room->superdeluxe_room_price = $request->room_price;
            $room->superdeluxe_room_amenity = $request->room_amenity;
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
