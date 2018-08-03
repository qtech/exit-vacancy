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
                        $check_login->last_login = date('d-m-y H:i:s');
                        $check_login->save();
                        
                        if($check_login->role == 2)
                        {
                            $customer = Customer::where(['user_id' => $check_login->user_id])->first();

                            $data = [
                                'user_id' => $check_login->user_id,
                                'fname' => $check_login->fname,
                                'lname' => $check_login->lname,
                                'role' => $check_login->role,
                                'number' => $customer->number,
                                'building' => $customer->building,
                                'street' => $customer->street,
                                'landmark' => $customer->landmark,
                                'city' => $customer->city,
                                'state' => $customer->state,
                                'country' => $customer->country,
                                'zipcode' => $customer->zipcode
                            ];

                            $response = [
                                'msg' => 'Login Successful',
                                'status' => 1,
                                'data' => $data
                            ];
                        }
                        else
                        {
                            $hotel = Hoteldata::where(['user_id' => $check_login->user_id])->first();

                            $data = [
                                'hotel_user_id' => $check_login->user_id,
                                'hotel_id' => $hotel->hotel_data_id,
                                'fname' => $check_login->fname,
                                'lname' => $check_login->lname,
                                'hotel_name' => $hotel->hotel_name,
                                'hotel_stars' => $hotel->stars,
                                'hotel_ratings' => $hotel->ratings,
                                'hotel_image' => ($hotel->image != NULL) ? $hotel->image : "",
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
                    'msg' => 'Oops! Some field is missing',
                    'status' => 0
                ];
            }
            else
            {
                $logout = User::where(['user_id' => $request->id, 'email' => $request->email])->first();
                
                if(count($logout) == 0)
                {
                    $response = [
                        'msg' => 'No such user found',
                        'status' => 0
                    ];
                }
                else
                {
                    $response = [
                        'msg' => 'Signout successful',
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
}
