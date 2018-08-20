<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;
use App\Customer;
use Illuminate\Support\Facades\Hash;
use App\Hoteldata;
use App\Bookings;
use DB;
use Mail;
use App\Mail\registration;

class AppuserController extends Controller
{
    public function customer_register(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'fname' => 'required',
                'lname' => 'required',
                'email' => 'required',
                'password' => 'required',
                'number' => 'required',
                'terms_status' => 'required'
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
                $check_email = User::where(['email' => $request->email])->first();

                if(count($check_email) > 0)
                {
                    $response = [
                        'msg' => 'This email id already used for registration.',
                        'status' => 0
                    ];
                }
                else
                {
                    $user = $request->all();
                    $user['password'] = Hash::make($request->password);
                    $user['role'] = 2;

                    $user = User::create($user);

                    $customer = $request->all();
                    $customer['user_id'] = $user->user_id;
                    
                    $customer = Customer::create($customer);

                    $data = [
                        'fname' => $user->fname,
                        'lname' => $user->lname,
                    ];
                    \Mail::to($user->email)->send(new registration($data));

                    $response = [
                        'msg' => "User registration successful",
                        'status' => 1
                    ];
                }
            }
        }
        catch(\Exception $e)
        {
            $response = [
                'msg' => $e->getMessage(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }

    public function hotel_register(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'fname' => 'required',
                'lname' => 'required',
                'email' => 'required',
                'password' => 'required',
                'hotel_name' => 'required',
                'number' => 'required',
                'building' => 'required',
                'street' => 'required',
                'landmark' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'zipcode' => 'required',
                'terms_status' => 'required'
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
                $check_email = User::where(['email' => $request->email])->first();

                if(count($check_email) > 0)
                {
                    $response = [
                        'msg' => 'This Email id is already registered.',
                        'status' => 0
                    ];
                }
                else
                {
                    $user = $request->all();
                    $user['password'] = Hash::make($request->password);
                    $user['role'] = 3;
                    $user = User::create($user);

                    $hotel = Hoteldata::orderBy('user_id', 'ASC')->first();
                    $hotel->hotel_name = $request->hotel_name;
                    $hotel->user_id = $user->user_id;
                    $hotel->number = $request->number;
                    $hotel->building = $request->building;
                    $hotel->street = $request->street;
                    $hotel->landmark = $request->landmark;
                    $hotel->city = $request->city;
                    $hotel->state = $request->state;
                    $hotel->country = $request->country;
                    $hotel->zipcode = $request->zipcode;
                    $hotel->terms_status = $request->terms_status;
                    $hotel->latitude = $request->latitude;
                    $hotel->longitude = $request->longitude;
                    $hotel->save();
                    
                    $data = [
                        'fname' => $user->fname,
                        'lname' => $user->lname,
                    ];
                    \Mail::to($user->email)->send(new registration($data));

                    $response = [
                        'msg' => 'Hotel registration Successful',
                        'status' => 1
                    ];
                }
            }
        }
        catch(\Exception $e)
        {
            $response = [
                'msg' => $e->getMessage(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }

    public function edit_customer_profile(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'user_id' => 'required',
                'fname' => 'required',
                'lname' => 'required',
                'number' => 'required',
                'role' => 'required'
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
                $user = User::where(['user_id' => $request->user_id,'role' => $request->role])->first();

                if(count($user) > 0)
                {
                    $user->fname = $request->fname;
                    $user->lname = $request->lname;
                    $user->save();

                    $profile = Customer::where(['user_id' => $user->user_id])->first();
                    if(count($profile) > 0)
                    {
                        $profile->number = $request->number;
                        $profile->save();

                        $response = [
                            'msg' => 'User profile successfully updated',
                            'status' => 1
                        ];
                    }
                    else
                    {
                        $response = [
                            'msg' => 'No profile details found for this user',
                            'status' => 0
                        ];
                    }
                }
                else
                {
                    $response = [
                        'msg' => 'No user available',
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

    public function user_bookings($id)
    {
        try
        {
            $userbookings = Bookings::where(['user_id' => $id])->get();

            if(count($userbookings) > 0)
            {
                $data = [];

                $hotel = Hoteldata::where(['hotel_data_id' => $userbookings->hotel_id])->first();

                $tmp = [
                    'hotel_name' => $hotel->hotel_name,
                    'roomtype' => $userbookings->roomtype,
                    'status' => $userbookings->status,
                    'roomprice' => $userbookings->roomprice,
                    'roomimage' => url("/")."/".$userbookings->roomimage,
                    'is_visited' => $userbookings->is_visited
                ];

                array_push($data, $tmp);

                $response = [
                    'msg' => 'User bookings list',
                    'status' => 1,
                    'data' => $data
                ];
            }
            else
            {
                $response = [
                    'msg' => 'Sorry! No records found',
                    'status' => 0
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

    public function userbooking_chart(Request $request)
    {
        try
        {
            if($request->id)
            {
                $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'), DB::raw('status'), DB::raw('is_visited'))->where(['user_id' => $request->id])->groupBy('date')->get();
            
                $dateLabel = ["2018-07-23","2018-07-26"];
                $completed = [2,6];
                $pending = [0,2];
                $cancelled = [1,3];

                foreach($bookings as $value)
                {
                    if($value->status == 1)
                    {
                        if($value->is_visited == 1)
                        {
                            array_push($dateLabel,$value->date);
                            array_push($completed,$value->count);
                            array_push($pending,0);
                            array_push($cancelled,0);
                        }
                        else
                        {
                            array_push($dateLabel,$value->date);
                            array_push($pending,$value->count);
                            array_push($completed,0);
                            array_push($cancelled,0);
                        }
                    }
                    else
                    {
                        array_push($dateLabel,$value->date);
                        array_push($cancelled,$value->count);
                        array_push($completed,0);
                        array_push($pending,0);
                    }
                }

                $response = [
                    'msg' => 'User Bookings',
                    'status' => 1,
                    'completed' => $completed,
                    'pending' => $pending,
                    'cancelled' => $cancelled,
                    'dateLabel' => $dateLabel
                ];
            }
            else
            {
                $response = [
                    'msg' => 'Invalid Parameters',
                    'status' => 0
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

    public function hotelbooking_chart(Request $request)
    {
        try
        {
            if($request->id)
            {
                $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'), DB::raw('status'), DB::raw('is_visited'))->where(['hotel_owner_id' => $request->id])->groupBy('date')->get();
            
                $dateLabel = ["2018-07-23","2018-07-26"];
                $completed = [2,6];
                $pending = [0,2];
                $cancelled = [1,3];

                foreach($bookings as $value)
                {
                    if($value->status == 1)
                    {
                        if($value->is_visited == 1)
                        {
                            array_push($dateLabel,$value->date);
                            array_push($completed,$value->count);
                            array_push($pending,0);
                            array_push($cancelled,0);
                        }
                        else
                        {
                            array_push($dateLabel,$value->date);
                            array_push($pending,$value->count);
                            array_push($completed,0);
                            array_push($cancelled,0);
                        }
                    }
                    else
                    {
                        array_push($dateLabel,$value->date);
                        array_push($cancelled,$value->count);
                        array_push($completed,0);
                        array_push($pending,0);
                    }
                }

                $response = [
                    'msg' => 'User Bookings',
                    'status' => 1,
                    'completed' => $completed,
                    'pending' => $pending,
                    'cancelled' => $cancelled,
                    'dateLabel' => $dateLabel
                ];
            }
            else
            {
                $response = [
                    'msg' => 'Invalid Parameters',
                    'status' => 0
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
}
