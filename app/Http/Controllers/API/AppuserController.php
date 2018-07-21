<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;
use App\Customer;
use Illuminate\Support\Facades\Hash;
use App\Hoteldata;

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
                    'msg' => "Oops! Some field is missing",
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
                    'msg' => 'Oops! Some field is missing',
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
                'building' => 'required',
                'street' => 'required',
                'landmark' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'zipcode' => 'required',
                'role' => 'required'
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
                        $profile->building = $request->building;
                        $profile->street = $request->street;
                        $profile->landmark = $request->landmark;
                        $profile->city = $request->city;
                        $profile->state = $request->state;
                        $profile->country = $request->country;
                        $profile->zipcode = $request->zipcode;
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
}
