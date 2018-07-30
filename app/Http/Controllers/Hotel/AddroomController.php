<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Hoteldata;
use App\User;

class AddroomController extends Controller
{
    public function add_king_room()
    {
        try
        {
            $room = Hoteldata::where(['user_id' => Auth()->user()->user_id])->first();
            return view('hotel_rooms.king.main')->with('room', $room);
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }

    public function add_king_room_images()
    {
        try
        {
            return view('hotel_rooms.king.addimage');
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }

    public function update_king_room(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'amenity' => 'required',
                'price' => 'required',
                'rooms' => 'required'
            ]);

            if($validator->fails())
            {
                $response = [
                    'msg' => 'Oops! Something is missing',
                    'status' => 0
                ];
            }
            else
            {
                $room = Hoteldata::where(['user_id' => Auth()->user()->user_id])->first();
                $room->king_room_amenity = $request->amenity;
                $room->king_room_price = $request->price;
                $room->king_room = $request->rooms;
                $room->save();

                $response = [
                    'msg' => 'Room details updated successfully',
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

    public function add_queen_room()
    {
        try
        {
            $room = Hoteldata::where(['user_id' => Auth()->user()->user_id])->first();
            return view('hotel_rooms.queen.main')->with('room', $room);
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }

    public function update_queen_room(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'amenity' => 'required',
                'price' => 'required',
                'rooms' => 'required'
            ]);

            if($validator->fails())
            {
                $response = [
                    'msg' => 'Oops! Something is missing',
                    'status' => 0
                ];
            }
            else
            {
                $room = Hoteldata::where(['user_id' => Auth()->user()->user_id])->first();
                $room->queen_room_amenity = $request->amenity;
                $room->queen_room_price = $request->price;
                $room->queen_room = $request->rooms;
                $room->save();

                $response = [
                    'msg' => 'Room details updated successfully',
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

    public function add_queen_room_images()
    {
        try
        {
            return view('hotel_rooms.queen.addimage');
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }
}
