<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Customer;
use App\Hoteldata;
use Validator;

class loginController extends Controller
{
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
                    'msg' => $validator->errors()->all(),
                    'status' => 0
                ];
            }
            else
            {
                $check_login = User::where(['email' => $request->email])->first();

                if($check_login)
                {
                    if($check_login->role == $request->type)
                    {
                        if($check_login->is_email_verify == 1)
                        {
                            if($check_login->role == 2)
                            {
                                if($check_login->is_mobile_verify == 1)
                                {
                                    if(Hash::check($request->password,$check_login->password))
                                    {
                                        $check_login->fcm_id = $request->fcm_id;
                                        $check_login->last_login = date('d-m-y H:i:s');
                                        $check_login->save();
    
                                        $customer = Customer::where(['user_id' => $check_login->user_id])->first();
            
                                        $data = [
                                            'user_id' => $check_login->user_id,
                                            'fname' => $check_login->fname,
                                            'lname' => $check_login->lname,
                                            'role' => $check_login->role,
                                            'number' => $customer->number,
                                            'user_image' => ($check_login->image != NULL) ? url("/")."/storage/uploads/".$check_login->image : "",
                                            'is_mobile_verified' => $check_login->is_mobile_verify == 1 ? "Yes" : "No"
                                        ];
            
                                        $response = [
                                            'msg' => 'Login Successful',
                                            'status' => 1,
                                            'data' => $data
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
                                        'msg' => 'Please verify your Mobile Number',
                                        'status' => 3,
                                        'user_id' => $check_login->user_id
                                    ];
                                }

                            }
                            else
                            {
                                if($check_login->is_mobile_verify == 1)
                                {
                                    if(Hash::check($request->password,$check_login->password))
                                    {
                                        $check_login->fcm_id = $request->fcm_id;
                                        $check_login->last_login = date('d-m-y H:i:s');
                                        $check_login->save();

                                        $hotel = Hoteldata::where(['user_id' => $check_login->user_id])->first();
                
                                        $data = [
                                            'hotel_user_id' => $check_login->user_id,
                                            'hotel_id' => $hotel->hotel_data_id,
                                            'fname' => $check_login->fname,
                                            'lname' => $check_login->lname,
                                            'bank_status' => $check_login->bank_status,
                                            'hotel_name' => $hotel->hotel_name,
                                            'hotel_stars' => $hotel->stars,
                                            'hotel_ratings' => $hotel->ratings,
                                            'hotel_user_image' => ($hotel->image != NULL) ? url("/")."/storage/uploads/".$hotel->image : "",
                                            'hotel_base_price' => $hotel->price,
                                            'role' => $check_login->role,
                                            'number' => $hotel->number,
                                            'building' => $hotel->building,
                                            'street' => $hotel->street,
                                            'landmark' => $hotel->landmark,
                                            'city' => $hotel->city,
                                            'state' => $hotel->state,
                                            'country' => $hotel->country,
                                            'zipcode' => $hotel->zipcode
                                        ];
            
                                        $response = [
                                            'msg' => 'Login Successful',
                                            'status' => 1,
                                            'data' => $data
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
                                        'msg' => 'Please verify your Mobile Number',
                                        'status' => 3,
                                        'user_id' => $check_login->user_id
                                    ];
                                }
                            }
                        }
                        else
                        {
                            $response = [
                                'msg' => 'Please verify your Email',
                                'status' => 2,
                                'user_id' => $check_login->user_id
                            ];
                        }
                    }
                    else
                    {
                        $response = [
                            'msg' => 'Un-Authorized Access!',
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
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }

    public function logout(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'id' => 'required',
                'email' => 'required'
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
                $logout = User::where(['user_id' => $request->id, 'email' => $request->email])->first();
                
                if($logout)
                {
                    $response = [
                        'msg' => 'Signout successful',
                        'status' => 1
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
