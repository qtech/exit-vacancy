<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;
use App\Hoteldata;
use App\Customer;
use App\Bookings;
use App\Ratereviews;

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
                $check_status = User::where(['user_id' => $request->hotel_owner_id, 'user_status' => 1])->first();

                if($check_status)
                {
                    $getdetails = Bookings::where(['hotel_id' => $request->hotel_id, 'hotel_owner_id' => $request->hotel_owner_id])->orderBy('created_at', 'DESC')->get();

                    $data = [];
                    
                    if(count($getdetails) > 0)
                    {
                        foreach($getdetails as $value)
                        {
                            $user = User::with('customer')->where(['user_id' => $value->user_id])->first();
                            
                            $tmp = [
                                'user_id' => $value->user_id,
                                'name' => $user->fname." ".$user->lname,
                                'email' => $user->email,
                                'user_image' => url("/")."/storage/uploads/".$user->image,
                                'number' => $user->customer->number,
                                'status' => $value->status,
                                'is_visited' => $value->is_visited,
                                'reference_id' => $value->ref_id,
                                'roomtype' => $value->roomtype,
                                'roomprice' => $value->roomprice,
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
                    else
                    {
                        $response = [
                            'msg' => 'No records found',
                            'status' => 0
                        ];
                    }
                }
                else
                {
                    $response = [
                        'msg' => 'Your account is not activated yet.',
                        'status' => 0
                    ];
                }
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
                    'msg' => $validator->errors()->all(),
                    'status' => 0
                ];
            }
            else
            {
                $check_status = User::where(['user_id' => $request->hotel_owner_id, 'user_status' => 1])->first();

                if($check_status)
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
                                'user_image' => url("/")."/storage/uploads/".$user->image,
                                'number' => $user->customer->number,
                                'status' => $value->status,
                                'is_visited' => $value->is_visited,
                                'reference_id' => $value->ref_id,
                                'roomtype' => $value->roomtype,
                                'roomprice' => $value->roomprice,
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
                else
                {
                    $response = [
                        'msg' => 'Your account is not activated yet.',
                        'status' => 0
                    ];
                }
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
                    'msg' => $validator->errors()->all(),
                    'status' => 0
                ];
            }   
            else
            {
                $check_status = User::where(['user_id' => $request->hotel_owner_id, 'user_status' => 1])->first();

                if($check_status)
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
                                'user_image' => url("/")."/storage/uploads/".$user->image,
                                'number' => $user->customer->number,
                                'status' => $value->status,
                                'is_visited' => $value->is_visited,
                                'reference_id' => $value->ref_id,
                                'roomtype' => $value->roomtype,
                                'roomprice' => $value->roomprice,
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
                else
                {
                    $response = [
                        'msg' => 'Your account is not activated yet.',
                        'status' => 0
                    ];
                }
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
                    'msg' => $validator->errors()->all(),
                    'status' => 0
                ];
            }
            else
            {
                $review = Ratereviews::with('user','hotel')->where(['hotel_id' => $request->hotel_id])->get();

                $data = [];
                $rate = 0;
                $r5 = 0;
                $r4 = 0;
                $r3 = 0;
                $r2 = 0;
                $r1 = 0;

                foreach($review as $tmp)
                {   
                    if($tmp->ratings == 5)
                    {
                        $r5 += $tmp->ratings;
                    }
                    if($tmp->ratings == 4)
                    {
                        $r4 += $tmp->ratings;
                    }
                    if($tmp->ratings == 3)
                    {
                        $r3 += $tmp->ratings;
                    }
                    if($tmp->ratings == 2)
                    {
                        $r2 += $tmp->ratings;
                    }
                    if($tmp->ratings == 1)
                    {
                        $r1 += $tmp->ratings;
                    }
                }

                $count = count($review);
                if($count > 0)
                {
                    $ratings = (($r5 + $r4 + $r3 + $r2 + $r1)/$count);
                }
                else
                {
                    $ratings = 0;
                }

                $gethotel = Hoteldata::where(['hotel_data_id' => $request->hotel_id])->first();

                if($gethotel)
                {
                    $image = [];

                    if($gethotel->image != NULL)
                    {
                        foreach(json_decode($gethotel->image) as $r)
                        {
                            $i = url('/')."/storage/uploads/".$r;
                            array_push($image,$i);
                        }
                    }
    
                    $data = [
                        'hotel_name' => $gethotel->hotel_name,
                        'stars' => $gethotel->stars,
                        'ratings' => $ratings,
                        'amenities' => $gethotel->amenities,
                        'hotel_image' => $image,
                        'number' => $gethotel->number,
                        'city' => $gethotel->city,
                        'state' => $gethotel->state,
                        'latitude' => $gethotel->latitude,
                        'longitude' => $gethotel->longitude
                    ];
    
                    if($request->roomtype == 1)
                    {
                        $roomimage = [];
    
                        if($gethotel->king_room_image != NULL)
                        {
                            foreach(json_decode($gethotel->king_room_image) as $j)
                            {
                                $k = url('/')."/storage/uploads/".$j;
                                array_push($roomimage,$k);
                            }
                        }
    
                        $data['room'] = [
                            'room_type' => "King Size Room",
                            'room_price' => $gethotel->king_room_price,
                            'room_image' => $roomimage,
                            'room_amenity' => $gethotel->king_room_amenity
                        ];
                    }
                    else
                    {
                        $roomimage = [];
                        
                        if($gethotel->queen_room_image != NULL)
                        {
                            foreach(json_decode($gethotel->queen_room_image) as $j)
                            {
                                $k = url('/')."/storage/uploads/".$j;
                                array_push($roomimage,$k);
                            }
                        }
    
                        $data['room'] = [
                            'room_type' => "2 Queens Room",
                            'room_price' => $gethotel->queen_room_price,
                            'room_image' => $roomimage,
                            'room_amenity' => $gethotel->queen_room_amenity
                        ];
                    }
    
                    $response = [
                        'msg' => 'Hotel details',
                        'status' => 1,
                        'data' => $data
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
            $response = [
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }
}
