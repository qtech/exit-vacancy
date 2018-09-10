<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;
use App\Customer;
use App\ImageUpload;
use Illuminate\Support\Facades\Hash;
use App\Hoteldata;
use App\Bookings;
use Storage;
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
                'lname' => 'nullable',
                'email' => 'required',
                'password' => 'required',
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

                if($check_email)
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
                    $user['user_status'] = 1;

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
                        'status' => 1,
                        'user_id' => $user->user_id
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

    public function hotel_register(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'fname' => 'required',
                'lname' => 'nullable',
                'email' => 'required',
                'password' => 'required',
                'hotel_name' => 'required',
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

                if($check_email)
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
                    $user['user_status'] = 0;
                    $user = User::create($user);

                    $hotel = Hoteldata::orderBy('user_id', 'ASC')->first();
                    $hotel->hotel_name = $request->hotel_name;
                    $hotel->status = 0;
                    $hotel->user_id = $user->user_id;
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
                        'status' => 1,
                        'user_id' => $user->user_id
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

    public function change_email(Request $request)
    {
        try
        {
            $change = User::find($request->user_id);

            if($change)
            {
                if($change->is_email_verfiy == 0)
                {
                    $checkemail = User::where(['email' => $request->email])->first();

                    if($checkemail)
                    {
                        $change->email = $request->email;
                        $change->save();
    
                        $response = [
                            'msg' => 'Email ID updated successfully',
                            'status' => 1
                        ]; 
                    }
                    else
                    {
                        $change->email = $request->email;
                        $change->save();
    
                        $response = [
                            'msg' => 'Email ID updated successfully',
                            'status' => 1
                        ]; 
                    }
                }
                else
                {
                    $response = [
                        'msg' => 'Sorry, your email ID is already registered. You can\'t change it now',
                        'status' => 0
                    ];
                }
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

    public function change_number(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
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
                $change = User::find($request->user_id);

                if($change)
                {
                    if($change->is_mobile_verfiy == 0)
                    {
                        if($request->role == 2)
                        {
                            $checknumber = Customer::where(['number' => $request->number])->first();
    
                            if($checknumber)
                            {
                                $response = [
                                    'msg' => 'This Number is already registered by other user. Please try some other number.',
                                    'status' => 0
                                ];
                            }
                            else
                            {
                                $number = Customer::where(['user_id' => $request->user_id])->first();
                                $number->number = $request->number;
                                $number->save();
            
                                $response = [
                                    'msg' => 'Mobile number updated successfully',
                                    'status' => 1
                                ]; 
                            }
                        }
                        if($request->role == 3)
                        {
                            $checkphone = Hoteldata::where(['number' => $request->number])->first();
    
                            if($checkphone)
                            {
                                $response = [
                                    'msg' => 'This Number is already registered by other hoteluser. Please try some other number.',
                                    'status' => 0
                                ]; 
                            }
                            else
                            {
                                $phone = Hoteldata::where(['user_id' => $request->user_id])->first();
                                $phone->number = $request->number;
                                $phone->save();
            
                                $response = [
                                    'msg' => 'Mobile number updated successfully',
                                    'status' => 1
                                ];  
                            }
                        }
                    }
                    else
                    {
                        $response = [
                            'msg' => 'Sorry, your number is already registered. You can\'t change it now',
                            'status' => 0
                        ];
                    }
                }
                else
                {
                    $response = [
                        'msg' => 'Invalid Parameters',
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

    public function get_user_details(Request $request)
    {
        try
        {
            $user = User::with('customer')->find($request->user_id);

            if($user)
            {
                $u['fname'] = $user->fname;
                $u['lname'] = $user->lname == NULL ? "" : $user->lname;
                $u['image'] = $user->image == NULL ? "" : url('/')."/storage/uploads/".$user->image;
                $u['role'] = $user->role;
                $u['number'] = $user->customer->number;

                $response = [
                    'msg' => 'User details',
                    'status' => 1,
                    'data' => $u
                ];
            }
            else
            {
                $response = [
                    'msg' => 'No such user found',
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

    public function get_hoteluser_details(Request $request)
    {
        try
        {
            $hotel = User::with('hotel')->find($request->user_id);

            if($hotel)
            {
                $u['fname'] = $hotel->fname;
                $u['lname'] = $hotel->lname == NULL ? "" : $hotel->lname;
                $u['image'] = $hotel->image == NULL ? "" : url('/')."/storage/uploads/".$hotel->image;
                $u['role'] = $hotel->role;
                $u['number'] = $hotel->hotel->number;

                $response = [
                    'msg' => 'Hotel User details',
                    'status' => 1,
                    'data' => $u
                ];
            }
            else
            {
                $response = [
                    'msg' => 'No such hoteluser found',
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

    public function edit_customer_profile(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'user_id' => 'required',
                'fname' => 'required',
                'lname' => 'nullable',
                'number' => 'required',
                'image' => 'nullable',
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

                if($user)
                {
                    $user->fname = $request->fname;
                    $user->lname = $request->lname;
                    
                    if($user->image != NULL)
                    {
                        Storage::delete(getenv('IMG_UPLOAD').$user->image);
                        $user->image = $request->image;
                    }

                    $user->save();

                    $profile = Customer::where(['user_id' => $user->user_id])->first();
                    if($profile->number != $request->number)
                    {
                        $profile->number = $request->number;
                        $profile->save();

                        $user->is_mobile_verify = 0;
                        $user->save();

                        $response = [
                            'msg' => 'User profile successfully updated',
                            'status' => 1
                        ];
                    }
                    else
                    {
                        $profile->number = $request->number;
                        $profile->save();
                        
                        $response = [
                            'msg' => 'User profile successfully updated',
                            'status' => 1
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
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }

    public function edit_hotel_profile(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'user_id' => 'required',
                'fname' => 'required',
                'lname' => 'nullable',
                'number' => 'required',
                'image' => 'nullable',
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
                $hotel = User::where(['user_id' => $request->user_id,'role' => $request->role])->first();

                if($hotel)
                {
                    $hotel->fname = $request->fname;
                    $hotel->lname = $request->lname;
                    
                    if($hotel->image != NULL)
                    {
                        Storage::delete(getenv('IMG_UPLOAD').$hotel->image);
                        $hotel->image = $request->image;
                    }

                    $hotel->save();

                    $profile = Hoteldata::where(['user_id' => $hotel->user_id])->first();
                    
                    if($profile->number != $request->number)
                    {
                        $profile->number = $request->number;
                        $profile->save();

                        $hotel->is_mobile_verify == 0;
                        $hotel->save();
                    }
                    else
                    {
                        $profile->number = $request->number;
                        $profile->save();
                    }

                    $response = [
                        'msg' => 'Hotel profile successfully updated',
                        'status' => 1
                    ];
                }
                else
                {
                    $response = [
                        'msg' => 'No hotel available',
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

    public function user_bookings($id)
    {
        try
        {
            $userbookings = Bookings::where(['user_id' => $id])->get();

            if(count($userbookings) > 0)
            {
                $data = [];

                $hotel = Hoteldata::where(['hotel_data_id' => $userbookings->hotel_id])->first();

                if($hotel)
                {
                    $tmp = [
                        'hotel_name' => $hotel->hotel_name,
                        'roomtype' => $userbookings->roomtype,
                        'status' => $userbookings->status,
                        'roomprice' => $userbookings->roomprice,
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
                        'msg' => 'No hotel found found',
                        'status' => 0
                    ];
                }   
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
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
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
                    'msg' => 'Hotel Bookings',
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
