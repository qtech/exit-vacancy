<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Hoteldata;
use App\User;
use App\ImageUpload;
use App\RoomAmenity;
use Storage;

class AddroomController extends Controller
{
    public function add_king_room()
    {
        try
        {
            $getdetails = [
                'room' => Hoteldata::where(['user_id' => Auth()->user()->user_id])->first(),
                'room_amenity' => RoomAmenity::where(['status' => 1])->get()
            ];
            return view('hotel_rooms.king.main')->with('getdetails',$getdetails);
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getFile()." ".$e->getLine();
        }
    }

    public function show_king_room_images($id)
    {
        try
        {
            $images = Hoteldata::where(['user_id' => $id])->first();
            return view('hotel_rooms.king.showimage')->with('images', $images);
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getFile()." ".$e->getLine();
        }
    }

    public function update_king_room(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                // 'amenities' => 'required',
                'price' => 'required',
                'rooms' => 'required',
                // 'images' => 'nullable'
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
                // $amenities = implode(",", $request->amenities);

                $room = Hoteldata::where(['user_id' => Auth()->user()->user_id])->first();
                // $room->king_room_amenity = $amenities;
                // if($request->hasFile('images'))
                // {
                //     if(!empty($room->king_room_image))
                //     {
                //         foreach(json_decode($room->king_room_image) as $image)
                //         {
                //             Storage::delete(getenv('IMG_UPLOAD').$image);
                //         }
                //         $room->king_room_image = ImageUpload::multipleimageupload($request,'images');
                //     }
                //     else
                //     {
                //         $room->king_room_image = ImageUpload::multipleimageupload($request,'images');
                //     }
                // }
                
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
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
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
            return $e->getMessage()." ".$e->getFile()." ".$e->getLine();
        }
    }

    public function update_queen_room(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                // 'amenities' => 'required',
                'price' => 'required',
                'rooms' => 'required',
                // 'images' => 'nullable'
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
                // $amenities = implode(",", $request->amenities);
                
                $room = Hoteldata::where(['user_id' => Auth()->user()->user_id])->first();
                // $room->queen_room_amenity = $amenities;
                $room->queen_room_price = $request->price;
                
                // if($request->hasFile('images'))
                // {
                //     if(!empty($room->queen_room_image))
                //     {
                //         foreach(json_decode($room->queen_room_image) as $image)
                //         {
                //             Storage::delete(getenv('IMG_UPLOAD').$image);
                //         }
                //         $room->queen_room_image = ImageUpload::multipleimageupload($request,'images');
                //     }
                //     else
                //     {
                //         $room->queen_room_image = ImageUpload::multipleimageupload($request,'images');
                //     }
                // }

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
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }

    public function show_queen_room_images($id)
    {
        try
        {
            $images = Hoteldata::where(['user_id' => $id])->first();
            return view('hotel_rooms.queen.showimage')->with('images', $images);
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getFile()." ".$e->getLine();
        }
    }
}
