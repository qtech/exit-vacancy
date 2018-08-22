<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Mail;
use App\Mail\resetpassword;
use App\User;
use App\randomPassword;


class resetpassController extends Controller
{
    public function resetpass(Request $request)
    {
        try
        {
            $check_email = User::where(['email' => $request->email])->first();

            if($check_email)
            {
                $password = randomPassword::randomPassword(7);
                $check_email->password = Hash::make($password);
                $check_email->save();

                $data = [
                    'fname' => $check_email->fname,
                    'lname' => $check_email->lname,
                    'email' => $request->email,
                    'password' => $password
                ];

                \Mail::to($request->email)->send(new resetpassword($data));

                $response = [
                    'msg' => "New password is sent to your Email",
                    'status' => 1
                ];
            }
            else
            {
                $response = [
                    'msg' => 'Invalid Email address',
                    'status' => 0
                ];
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

    public function changepass(Request $request)
    {
        try
        {
            $check_email = User::where(['user_id' => $request->user_id])->first();

            if(count($check_email) > 0)
            {
                if(Hash::check($request->old_password,$check_email->password))
                {
                    $check_email->password = Hash::make($request->new_password);
                    $check_email->save();

                    $response = [
                        'msg' => 'Password changed successfully',
                        'status' => 1
                    ];
                }
                else
                {
                    $response = [
                        'msg' => 'Invalid Old Password',
                        'status' => 0
                    ];
                }
            }
            else
            {
                $response = [
                    'msg' => 'Invalid Email address',
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
}
