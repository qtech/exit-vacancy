<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;
use App\Hoteldata;
use App\Customer;
use App\Bookings;

class HotelbookingdetailsController extends Controller
{
    public function bookingdetails_hotel(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'hotel_id' => 'required',
                'hotel_owner_id' => 'required'
            ]);

            if($validator->fails())
            {
                $response = [
                    'msg' => 'Oops! Some field is missing',
                    'status' => 0
                ];
            }
            else
            {
                $getdetails = Bookings::where(['hotel_id' => $request->hotel_id, 'hotel_owner_id' => $request->hotel_owner_id])->orderBy('created_at', 'DESC')->get();

                $data = [];

                foreach($getdetails as $value)
                {
                    $user = User::with('customer')->where(['user_id' => $value->user_id])->first();

                    $tmp = [
                        'user_id' => $value->user_id,
                        'name' => $user->fname." ".$user->lname,
                        'email' => $user->email,
                        'number' => $user->customer->number,
                        'status' => $value->status,
                        'location' => $user->customer->city." ".$user->customer->state,
                        'is_visited' => $value->is_visited,
                        'reference_id' => $value->ref_id,
                        'roomtype' => $value->roomtype,
                        'roomprice' => $value->roomprice,
                        'roomimage' => url("/")."/".$value->roomimage,
                        'roomamenity' => $value->roomamenity,
                        'arrival_time' => $value->arrival_time,
                        'time' => $value->created_at->format('d-m-y H:i:s')
                    ];

                    array_push($data,$tmp);
                }

                $response = [
                    'msg' => 'Users who have sent request for booking a room',
                    'status' => 1,
                    'data' => $data
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

    public function visiting_guest(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'hotel_id' => 'required',
                'hotel_owner_id' => 'required'
            ]);

            if($validator->fails())
            {
                $response = [
                    'msg' => 'Oops! Some field is missing',
                    'status' => 0
                ];
            }
            else
            {
                $visiting = Bookings::where(['hotel_id' => $request->hotel_id, 'hotel_owner_id' => $request->hotel_owner_id, 'status' => 1, 'is_visited' => 0])->get();

                if(count($visiting) == 0)
                {
                    $response = [
                        'msg' => 'Sorry! No records found',
                        'status' => 0
                    ];
                }
                else
                {
                    $data = [];

                    foreach($visiting as $value)
                    {
                        $user = User::with('customer')->where(['user_id' => $value->user_id])->first();

                        $tmp = [
                            'user_id' => $value->user_id,
                            'name' => $user->fname." ".$user->lname,
                            'email' => $user->email,
                            'number' => $user->customer->number,
                            'status' => $value->status,
                            'location' => $user->customer->city." ".$user->customer->state,
                            'is_visited' => $value->is_visited,
                            'reference_id' => $value->ref_id,
                            'roomtype' => $value->roomtype,
                            'roomprice' => $value->roomprice,
                            'roomimage' => url("/")."/".$value->roomimage,
                            'roomamenity' => $value->roomamenity,
                            'arrival_time' => $value->arrival_time,
                            'time' => $value->created_at->format('d-m-y H:i:s')
                        ];
    
                        array_push($data,$tmp);
                    }

                    $response = [
                        'msg' => count($visiting)." visiting guests",
                        'status' => 1,
                        'data' => $data
                    ];
                }
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

    public function visited_guest(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'hotel_id' => 'required',
                'hotel_owner_id' => 'required'
            ]);
    
            if($validator->fails())
            {   
                $response = [
                    'msg' => 'Oops! Some field is missing',
                    'status' => 0
                ];
            }   
            else
            {
                $visited = Bookings::where(['hotel_id' => $request->hotel_id, 'hotel_owner_id' => $request->hotel_owner_id, 'status' => 1, 'is_visited' => 1])->orderBy('created_at','DESC')->get();
    
                if(count($visited) == 0)
                {
                    $response = [
                        'msg' => 'Sorry! No records found',
                        'status' => 0
                    ];
                }
                else
                {
                    $data = [];
    
                    foreach($visited as $value)
                    {
                        $user = User::with('customer')->where(['user_id' => $value->user_id])->first();
    
                        $tmp = [
                            'user_id' => $value->user_id,
                            'name' => $user->fname." ".$user->lname,
                            'email' => $user->email,
                            'number' => $user->customer->number,
                            'status' => $value->status,
                            'location' => $user->customer->city." ".$user->customer->state,
                            'is_visited' => $value->is_visited,
                            'reference_id' => $value->ref_id,
                            'roomtype' => $value->roomtype,
                            'roomprice' => $value->roomprice,
                            'roomimage' => url("/")."/".$value->roomimage,
                            'roomamenity' => $value->roomamenity,
                            'time' => $value->created_at->format('d-m-y H:i:s')
                        ];
    
                        array_push($data,$tmp);
                    }   
    
                    $response = [
                        'msg' => count($visited)." visited guests",
                        'status' => 1,
                        'data' => $data
                    ];
                }
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

    public function hotel_details_for_user(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'hotel_id' => 'required',
                'roomtype' => 'required'
            ]);

            if($validator->fails())
            {
                $response = [
                    'msg' => 'Oops! Some field is missing',
                    'status' => 0
                ];
            }
            else
            {
                $gethotel = Hoteldata::where(['hotel_data_id' => $request->hotel_id])->first();

                $data = [
                    'hotel_name' => $gethotel->hotel_name,
                    'stars' => $gethotel->stars,
                    'ratings' => $gethotel->ratings,
                    'hotel_image' => $gethotel->image,
                    'number' => $gethotel->number,
                    'base_price' => $gethotel->price,
                    'city' => $gethotel->city,
                    'state' => $gethotel->state
                ];

                if($request->roomtype == 1)
                {
                    $data['room'] = [
                        'room_type' => "King Size Room",
                        'room_price' => $gethotel->king_room_price,
                        'room_image' => url("/")."/".$gethotel->king_room_image,
                        'room_amenity' => $gethotel->king_room_amenity
                    ];
                }
                else
                {
                    $data['room'] = [
                        'room_type' => "2 Queens Room",
                        'room_price' => $gethotel->queen_room_price,
                        'room_image' => url("/")."/".$gethotel->queen_room_image,
                        'room_amenity' => $gethotel->queen_room_amenity
                    ];
                }

                $response = [
                    'msg' => 'Hotel details',
                    'status' => 1,
                    'data' => $data
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
