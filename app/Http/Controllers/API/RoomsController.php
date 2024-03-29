<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hoteldata;
use App\ImageUpload;
use Validator;
use Storage;


class RoomsController extends Controller
{
    public function getRoomdetails(Request $request)
    {
        try
        {
            $room = Hoteldata::where(['user_id' => $request->hotel_id])->first();

            $kingroom = [];
            $queenroom = [];

            // if(!empty($room->king_room_image))
            // {
            //     foreach(json_decode($room->king_room_image) as $k)
            //     {
            //         $s = url('/')."/storage/uploads/".$k;
            //         array_push($kingroom,$s);
            //     }
            // }

            // if(!empty($room->queen_room_image))
            // {
            //     foreach(json_decode($room->queen_room_image) as $q)
            //     {
            //         $j = url('/')."/storage/uploads/".$q;
            //         array_push($queenroom,$j);
            //     }
            // }

            $data = [
                [
                    'room_type' => "King Size Room",
                    'room_available' => $room->king_room,
                    // 'room_image' => $kingroom,
                    'room_price' => $room->king_room_price,
                    // 'room_amenity' => ($room->king_room_amenity != NULL) ? $room->king_room_amenity : ""
                ],
                [
                    'room_type' => "Queen Size Room",
                    'room_available' => $room->queen_room,
                    // 'room_image' => $queenroom,
                    'room_price' => $room->queen_room_price,
                    // 'room_amenity' => ($room->queen_room_amenity != NULL) ? $room->queen_room_amenity : ""
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
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }

    public function update_kingRoom(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'room_available' => 'required',
                // 'images' => 'nullable',
                'room_price' => 'required',
                // 'room_amenity' => 'required',
                'hotel_id' => 'required'
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
                $room = Hoteldata::where(['hotel_data_id' => $request->hotel_id])->first();

                if($room)
                {
                    $room->king_room = $request->room_available;
                    $room->king_room_price = $request->room_price;
                    
                    // if($room->king_room_image != NULL)
                    // {
                    //     foreach(json_decode($room->king_room_image) as $image)
                    //     {
                    //         Storage::delete(url('/')."/public/uploads/".$image);
                    //     }
                    //     if(!empty($request->images))
                    //     {
                    //         $room->king_room_image = json_encode($request->images);
                    //     }  
                    // }
                    // else
                    // {
                    //     if(!empty($request->images))
                    //     {
                    //         $room->king_room_image = json_encode($request->images);
                    //     }
                    // }
                    
                    // $room->king_room_amenity = $request->room_amenity;
                    $room->king_room_status = 1;
                    $room->save();
        
                    $response = [
                        'msg' => 'Room details successfully updated',
                        'status' => 1
                    ];
                }   
                else
                {
                    $response = [
                        'msg' => 'No data found',
                        'status' => 0
                    ];
                }
            }
        }
        catch(\Exception $e)
        {
            $response =  [
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }

    public function update_queenRoom(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'room_available' => 'required',
                // 'images' => 'nullable',
                'room_price' => 'required',
                // 'room_amenity' => 'required',
                'hotel_id' => 'required'
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
                $room = Hoteldata::where(['hotel_data_id' => $request->hotel_id])->first();

                if($room)
                {
                    $room->queen_room = $request->room_available;
                    $room->queen_room_price = $request->room_price;
                    
                    // if(!empty($room->queen_room_image))
                    // {
                    //     foreach(json_decode($room->queen_room_image) as $image)
                    //     {
                    //         Storage::delete(getenv('IMG_UPLOAD').$image);
                    //     }
                    //     if(!empty($request->images))
                    //     {
                    //         $room->queen_room_image = json_encode($request->images);
                    //     }
                    // }
                    // else
                    // {
                    //     if(!empty($request->images))
                    //     {
                    //         $room->queen_room_image = json_encode($request->images);
                    //     }
                    // }

                    // $room->queen_room_amenity = $request->room_amenity;
                    $room->queen_room_status = 1;
                    $room->save();
        
                    $response = [
                        'msg' => 'Room details successfully updated',
                        'status' => 1
                    ];
                }   
                else
                {
                    $response = [
                        'msg' => 'No data found',
                        'status' => 0
                    ];
                }
            }
        }
        catch(\Exception $e)
        {
            $response =  [
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }
}
