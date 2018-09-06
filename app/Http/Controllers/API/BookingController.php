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
                    $decline = Bookings::where(['user_id' => $request->user_id, 'hotel_owner_id' => $request->hotel_id, 'ref_id' => $request->reference_id, 'status' => 0])->first();
                    
                    if($decline)
                    {
                        $hotel = User::where(['user_id' => $decline->hotel_owner_id])->first();
                        $result = Notifications::otherhotelacceptNotification($hotel->fcm_id, $hotel->device);
                        $decline->status = 3;
                        $decline->status_time = date('d-m-y H:i:s');
                        $decline->save();
                    }
                }
                else
                {
                    $hotel = Hoteldata::where(['user_id' => $request->hotel_id])->first();

                    if($request->roomtype == 1)
                    {
                        if($hotel->king_room > 0)
                        {
                            $hotel->king_room = $hotel->king_room - 1;
                            $hotel->save();
                        }
                        else
                        {
                            $response = [
                                'msg' => 'Sorry, you cant accept this request as there are no rooms available',
                                'status' => 1
                            ];

                            return response()->json($response);
                        }
                    }
                    else
                    {
                        if($hotel->queen_room > 0)
                        {
                            $hotel->queen_room = $hotel->queen_room - 1;
                            $hotel->save();
                        }
                        else
                        {
                            $response = [
                                'msg' => 'Sorry, you cant accept this request as there are no rooms available',
                                'status' => 1
                            ];

                            return response()->json($response);
                        }
                    }

                    $accept = Bookings::where(['user_id' => $request->user_id,'hotel_owner_id' => $request->hotel_id,'status' => 0, 'ref_id' => $request->reference_id])->first();

                    if($accept)
                    {
                        $accept->status = 1;
                        $accept->status_time = date('d-m-y H:i:s');
                        $accept->save();

                        $delete = Bookings::where(['user_id' => $request->user_id,'hotel_owner_id' => $request->hotel_id,'status' => 0, 'ref_id' => $request->reference_id])->get();

                        foreach($delete as $value)
                        {
                            $del = Bookings::find($value->booking_id);
                            $del->delete();
                        }
                    }

                    $count_user_booking = User::where(['user_id' => $request->user_id])->first();

                    if($count_user_booking)
                    {
                        $count_user_booking->bookings = $count_user_booking->bookings + 1;
                        $count_user_booking->save();
                    }

                    $count_hotel_booking = User::where(['user_id' => $request->hotel_id])->first();

                    if($count_hotel_booking)
                    {
                        $count_hotel_booking->bookings = $count_hotel_booking->bookings + 1;
                        $count_hotel_booking->save();
                    }

                    $collect = [
                        'ref_id' => $request->reference_id,
                        'hotel_data_id' => $hotel->hotel_data_id,
                        'hotel_owner_id' => $request->hotel_id,
                        'hotel_name' => $hotel->hotel_name,
                        'roomtype' => $request->roomtype
                    ];

                    $user = User::where(['user_id' => $request->user_id])->first();
                    $result = Notifications::hotelacceptNotification($user->fcm_id, $user->device, $collect);

                    $data = [
                        'fname' => $user->fname,
                        'lname' => $user->lname,
                        'hotel_name' => $hotel->hotel_name,
                        'roomtype' => $request->roomtype == 1 ? "King Size" : "Two-Queens"
                    ];

                    \Mail::to($user->email)->send(new booked($data));

                    $decline = Bookings::where(['user_id' => $request->user_id, 'status' => 0, 'ref_id' => $request->reference_id])->get();
                    
                    if(count($decline) > 0)
                    {
                        foreach($decline as $value)
                        {
                            $hotel = User::where(['user_id' => $value->hotel_owner_id])->first();
                            $result = Notifications::otherhotelacceptNotification($hotel->fcm_id, $hotel->device);
                            $value->status = 3;
                            $value->status_time = date('d-m-y H:i:s');
                            $value->save();
                        }
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
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
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

                if($check)
                {
                    $response = [
                        'msg' => "This user's request is already accepted by other hotel",
                        'status' => 0
                    ];
                }
                else
                {
                    $decline = Bookings::where(['user_id' => $request->user_id, 'hotel_owner_id' => $request->hotel_id, 'status' => 0, 'ref_id' => $request->reference_id])->first();

                    if($decline)
                    {
                        $decline->status = 2;
                        $decline->status_time = date('d-m-y H:i:s');
                        $decline->save();
                    }

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
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
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
                $result = Notifications::hotelnoresponseNotification($user->fcm_id, $user->device);

                $response = [
                    'msg' => 'Sorry! No response from any hotels',
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
                
                if($visited)
                {
                    if($visited->payment_status == 1)
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
                            'msg' => 'User payment for this booking is DUE',
                            'status' => 0
                        ];
                    }
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
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
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
                        
                        $hotelimage = [];

                        if($hotel->image != NULL)
                        {
                            foreach(json_decode($hotel->image) as $k)
                            {
                                $s = url('/')."/storage/uploads/".$k;
                                array_push($hotelimage,$s);
                            }
                        }

                        $roomimage = [];

                        if($recent->roomimage != NULL)
                        {
                            foreach(json_decode($recent->roomimage) as $b)
                            {
                                $d = url('/')."/storage/uploads/".$b;
                                array_push($roomimage,$d);
                            }
                        }

                        $tmp = [
                            'ref_id' => $recent->ref_id,
                            'payment_status' => $recent->payment_status,
                            'hotel_id' => $hotel->hotel_data_id,
                            'hotel_owner_id' => $hotel->user_id,
                            'hotel_name' => $hotel->hotel_name,
                            // 'amenities' => $hotel->amenities,
                            'stars' => $hotel->stars,
                            'ratings' => $hotel->ratings,
                            'image' => $hotelimage,
                            'number' => $hotel->number,
                            'city' => $hotel->city,
                            'state' => $hotel->state,
                            'latitude' => $hotel->latitude,
                            'longitude' => $hotel->longitude,
                            'booked_room' => [
                                [
                                    'roomtype' => $recent->roomtype,
                                    'roomprice' => $recent->roomprice,
                                    // 'roomimage' => $roomimage,
                                    // 'roomamenity' => $recent->roomamenity
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
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
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

                        $hotelimage = [];

                        if($hotel->image != NULL)
                        {
                            foreach(json_decode($hotel->image) as $k)
                            {
                                $s = url('/')."/storage/uploads/".$k;
                                array_push($hotelimage,$s);
                            }
                        }

                        // $roomimage = [];

                        // if($recent->roomimage != NULL)
                        // {
                        //     foreach(json_decode($recent->roomimage) as $b)
                        //     {
                        //         $d = url('/')."/storage/uploads/".$b;
                        //         array_push($roomimage,$d);
                        //     }
                        // }

                        $tmp = [
                            'hotel_id' => $hotel->hotel_data_id,
                            'hotel_name' => $hotel->hotel_name,
                            // 'amenities' => $hotel->amenities,
                            // 'stars' => $hotel->stars,
                            'ratings' => $hotel->ratings,
                            'image' => $hotelimage,
                            'number' => $hotel->number,
                            'city' => $hotel->city,
                            'state' => $hotel->state,
                            'latitude' => $hotel->latitude,
                            'longitude' => $hotel->longitude,
                            'booked_room' => [
                                [
                                    'roomtype' => $recent->roomtype,
                                    'roomprice' => $recent->roomprice,
                                    // 'roomimage' => $roomimage,
                                    // 'roomamenity' => $recent->roomamenity
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
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
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
