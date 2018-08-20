<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;
use App\Bookings;
use App\Hoteldata;
use App\Notifications;
use DB;
use Mail;
use App\Mail\booked;
use App\Mail\arrived;

class BookingController extends Controller
{
    public function hotel_accepted(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'user_id' => 'required',
                'hotel_id' => 'required',
                'reference_id' => 'required',
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
                $check = Bookings::where(['status' => 1,'ref_id' => $request->reference_id])->get();
                
                if(count($check) > 0)
                {
                    $decline = Bookings::where(['user_id' => $request->user_id, 'hotel_id' => $request->hotel_id, 'ref_id' => $request->reference_id, 'status' => 3])->first();
                    
                    $hotel = User::where(['user_id' => $decline->hotel_owner_id])->first();
                    $result = Notifications::otherhotelacceptNotification($hotel->fcm_id);
                    $decline->status = 3;
                    $decline->status_time = date('d-m-y H:i:s');
                    $decline->save();
                }
                else
                {
                    $accept = Bookings::where(['user_id' => $request->user_id,'hotel_owner_id' => $request->hotel_id,'status' => 0, 'ref_id' => $request->reference_id])->first();
                    $accept->status = 1;
                    $accept->status_time = date('d-m-y H:i:s');
                    $accept->save();

                    $count_user_booking = User::where(['user_id' => $request->user_id])->first();
                    $count_user_booking->bookings = $count_user_booking->bookings + 1;
                    $count_user_booking->save();

                    $count_hotel_booking = User::where(['user_id' => $request->hotel_id])->first();
                    $count_hotel_booking->bookings = $count_hotel_booking->bookings + 1;
                    $count_hotel_booking->save();

                    $hotel = Hoteldata::where(['user_id' => $request->hotel_id])->first();

                    if($request->roomtype == 1)
                    {
                        if(count($hotel->king_room) > 0)
                        {
                            $hotel->king_room = $hotel->king_room - 1;
                            $hotel->save();
                        }
                    }
                    else
                    {
                        if(count($hotel->queen_room) > 0)
                        {
                            $hotel->queen_room = $hotel->queen_room - 1;
                            $hotel->save();
                        }
                    }

                    $collect = [
                        'hotel_data_id' => $hotel->hotel_data_id,
                        'hotel_name' => $hotel->hotel_name,
                        'roomtype' => $request->roomtype == 1 ? "King Size" : "Two-Queens"
                    ];

                    $user = User::where(['user_id' => $request->user_id])->first();
                    $result = Notifications::hotelacceptNotification($user->fcm_id, $collect);

                    $data = [
                        'fname' => $user->fname,
                        'lname' => $user->lname,
                        'hotel_name' => $hotel->hotel_name,
                        'roomtype' => $request->roomtype == 1 ? "King Size" : "Two-Queens"
                    ];

                    \Mail::to($user->email)->send(new booked($data));

                    $decline = Bookings::where(['user_id' => $request->user_id, 'status' => 0, 'ref_id' => $request->reference_id])->get();
                    
                    foreach($decline as $value)
                    {
                        $hotel = User::where(['user_id' => $value->hotel_owner_id])->first();
                        $result = Notifications::otherhotelacceptNotification($hotel->fcm_id);
                        $value->status = 3;
                        $value->status_time = date('d-m-y H:i:s');
                        $value->save();
                    }
                }                

                $response = [
                    'msg' => 'Success!',
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

    public function hotel_declined(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'user_id' => 'required',
                'hotel_id' => 'required',
                'reference_id' => 'required'
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
                $check = Bookings::where(['user_id' => $request->user_id, 'hotel_owner_id' => $request->hotel_id, 'status' => 2, 'ref_id' => $request->reference_id])->first();

                if(count($check) > 0)
                {
                    $response = [
                        'msg' => "This user's request is already accepted by other hotel",
                        'status' => 0
                    ];
                }
                else
                {
                    $decline = Bookings::where(['user_id' => $request->user_id, 'hotel_owner_id' => $request->hotel_id, 'status' => 0, 'ref_id' => $request->reference_id])->first();
                    $decline->status = 2;
                    $decline->status_time = date('d-m-y H:i:s');
                    $decline->save();

                    $response = [
                        'msg' => 'Request declined',
                        'status' => 1
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

    public function hotel_noresponse(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'user_id' => 'required'
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
                $noresponse = Bookings::where(['user_id' => $request->user_id, 'status' => 0])->get();

                foreach($noresponse as $value)
                {
                    $value->status = 3;
                    $value->status_time = date('d-m-y H:i:s');
                    $value->save();
                }
                
                $user = User::where(['user_id' => $request->user_id])->first();
                $result = Notifications::hotelnoresponseNotification($user->fcm_id);

                $response = [
                    'msg' => 'Sorry! No response from any hotels',
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

    public function hotel_is_visited(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'user_id' => 'required',
                'hotel_id' => 'required',
                'reference_id' => 'required'
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
                $visited = Bookings::where(['user_id' => $request->user_id,'hotel_id' => $request->hotel_id, 'status' => 1, 'ref_id' => $request->reference_id , 'is_visited' => 0])->first();

                if(count($visited) > 0)
                {
                    $visited->is_visited = 1;
                    $visited->visited_time = date('d-m-y H:i:s');
                    $visited->save();

                    $user = User::where(['user_id' => $request->user_id])->first();
                    $hotel = Hoteldata::where(['hotel_data_id' => $request->hotel_id])->first();

                    $data = [
                        'fname' => $user->fname,
                        'lname' => $user->lname,
                        'hotel_name' => $hotel->hotel_name
                    ];

                    \Mail::to($user->email)->send(new arrived($data));

                    $response = [
                        'msg' => 'Success!',
                        'status' => 1
                    ];
                }
                else
                {
                    $response = [
                        'msg' => 'Oops! No record found',
                        'status' => 0
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

    public function user_recent_booking(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'user_id' => 'required'
            ]);

            if($validator->fails())
            {
                $reponse = [
                    'msg' => $validator->errors()->all(),
                    'status' => 0
                ];
            }
            else
            {
                $recent_booking = Bookings::where(['user_id' => $request->user_id, 'status' => 1, 'is_visited' => 0])->get();

                if(count($recent_booking) > 0)
                {
                    $data = [];

                    foreach($recent_booking as $recent)
                    {
                        $hotel = Hoteldata::where(['hotel_data_id' => $recent->hotel_id])->first();
                    
                        $tmp = [
                            'hotel_id' => $hotel->hotel_data_id,
                            'hotel_name' => $hotel->hotel_name,
                            'amenities' => $hotel->amenities,
                            'stars' => $hotel->stars,
                            'ratings' => $hotel->ratings,
                            'image' => $hotel->image,
                            'number' => $hotel->number,
                            'city' => $hotel->city,
                            'state' => $hotel->state,
                            'latitude' => $hotel->latitude,
                            'longitude' => $hotel->longitude,
                            'booked_room' => [
                                [
                                    'roomtype' => $recent->roomtype,
                                    'roomprice' => $recent->roomprice,
                                    'roomimage' => ($recent->roomimage != NULL) ? url("/")."/".$recent->roomimage : "",
                                    'roomamenity' => $recent->roomamenity
                                ]   
                            ]
                        ];

                        array_push($data,$tmp);
                    }
    
                    $response = [
                        'msg' => 'Recent Booking',
                        'status' => 1,
                        'data' => $data
                    ];
                }
                else
                {
                    $response = [
                        'msg' => 'No recent bookings available',
                        'status' => 0
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

    public function user_past_booking(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'user_id' => 'required'
            ]);

            if($validator->fails())
            {
                $reponse = [
                    'msg' => $validator->errors()->all(),
                    'status' => 0
                ];
            }
            else
            {
                $past = Bookings::where(['user_id' => $request->user_id, 'status' => 1, 'is_visited' => 1])->get();
                
                if(count($past) > 0)
                {
                    $data = [];

                    foreach($past as $recent)
                    {
                        $hotel = Hoteldata::where(['hotel_data_id' => $recent->hotel_id])->first();

                        $tmp = [
                            'hotel_id' => $hotel->hotel_data_id,
                            'hotel_name' => $hotel->hotel_name,
                            'amenities' => $hotel->amenities,
                            'stars' => $hotel->stars,
                            'ratings' => $hotel->ratings,
                            'image' => $hotel->image,
                            'number' => $hotel->number,
                            'city' => $hotel->city,
                            'state' => $hotel->state,
                            'latitude' => $hotel->latitude,
                            'longitude' => $hotel->longitude,
                            'booked_room' => [
                                [
                                    'roomtype' => $recent->roomtype,
                                    'roomprice' => $recent->roomprice,
                                    'roomimage' => ($recent->roomimage != NULL) ? url("/")."/".$recent->roomimage : "",
                                    'roomamenity' => $recent->roomamenity
                                ]   
                            ]
                        ];

                        array_push($data,$tmp);
                    }
    
                    $response = [
                        'msg' => 'Past Bookings',
                        'status' => 1,
                        'data' => $data
                    ];
                }
                else
                {
                    $response = [
                        'msg' => 'No past bookings available',
                        'status' => 0
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

    public function pendingbookingchart()
    {
        try
        {
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1, 'is_visited' => 0])->groupBy('date')->get();
            
            $dateLabel = ["2018-07-23","2018-07-26","2018-07-31"];
            $booking = [2,6,0];

            foreach($bookings as $value)
            {
                array_push($booking,$value->count);
                array_push($dateLabel,$value->date);
            }

            $response = [
                'msg' => 'Bookings Day-wise',
                'status' => 1,
                'bookings' => $booking,
                'dateLabel' => $dateLabel
            ];
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

    public function cancelbookingchart()
    {
        try
        {
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 2])->groupBy('date')->get();
            
            $dateLabel = ["2018-07-15","2018-07-21","2018-07-27"];
            $booking = [0,2,1   ];

            foreach($bookings as $value)
            {
                array_push($booking,$value->count);
                array_push($dateLabel,$value->date);
            }

            $response = [
                'msg' => 'Bookings Day-wise',
                'status' => 1,
                'bookings' => $booking,
                'dateLabel' => $dateLabel
            ];
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
