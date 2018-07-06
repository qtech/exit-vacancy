<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Customer;
use App\Hotel;
use Validator;

class loginController extends Controller
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
                        'msg' => "Registration successful",
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

                    $hotel = $request->all();
                    $hotel['user_id'] = $user->user_id;
                    $hotel = Hotel::create($hotel);

                    $response = [
                        'msg' => 'Registration Successful',
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

    public function check_login(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'email' => 'required',
                'password' => 'required',
                'fcm_id' => 'required'
            ]);

            if($validator->fails())
            {
                $response = [
                    'msg' => 'Oops! Some field is missing.',
                    'status' => 0
                ];
            }
            else
            {
                $check_login = User::where(['email' => $request->email])->first();

                if(count($check_login) > 0)
                {
                    if(Hash::check($request->password,$check_login->password))
                    {
                        $check_login->fcm_id = $request->fcm_id;
                        $check_login->save();

                        $response = [
                            'msg' => 'Login Successful',
                            'status' => 1,
                            'id' => $check_login->user_id,
                            'role' => $check_login->role
                        ];
                    }
                    else
                    {
                        $response = [
                            'msg' => 'Invalid Password.',
                            'status' => 0,
                        ];
                    }
                }
                else
                {
                    $response = [
                        'msg' => 'Invalid Email id.',
                        'status' => 0,
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
}
