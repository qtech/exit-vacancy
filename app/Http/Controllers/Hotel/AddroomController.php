<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Hoteldata;
use App\User;

class AddroomController extends Controller
{
    public function add_standard_room()
    {
        try
        {
            $room = Hoteldata::where(['user_id' => Auth()->user()->user_id])->first();
            return view('hotel_addrooms.standard.main')->with('room', $room);
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }

    public function add_standard_room_images()
    {
        try
        {
            return view('hotel_addrooms.standard.addimage');
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }

    public function update_standard_room(Request $request)
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
                $room->standard_room_amenity = $request->amenity;
                $room->standard_room_price = $request->price;
                $room->standard_room = $request->rooms;
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

    public function add_deluxe_room()
    {
        try
        {
            $room = Hoteldata::where(['user_id' => Auth()->user()->user_id])->first();
            return view('hotel_addrooms.deluxe.main')->with('room', $room);
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }

    public function update_deluxe_room(Request $request)
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
                $room->deluxe_room_amenity = $request->amenity;
                $room->deluxe_room_price = $request->price;
                $room->deluxe_room = $request->rooms;
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

    public function add_deluxe_room_images()
    {
        try
        {
            return view('hotel_addrooms.deluxe.addimage');
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }

    public function add_superdeluxe_room()
    {
        try
        {
            $room = Hoteldata::where(['user_id' => Auth()->user()->user_id])->first();
            return view('hotel_addrooms.superdeluxe.main')->with('room', $room);
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }

    public function update_superdeluxe_room(Request $request)
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
                $room->superdeluxe_room_amenity = $request->amenity;
                $room->superdeluxe_room_price = $request->price;
                $room->superdeluxe_room = $request->rooms;
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

    public function add_superdeluxe_room_images()
    {
        try
        {
            return view('hotel_addrooms.superdeluxe.addimage');
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }
}
