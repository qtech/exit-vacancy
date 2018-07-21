<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use App\Mail\emailverify;
use App\User;
use App\randomPassword;

class verificationController extends Controller
{
    public function emailverify(Request $request)
    {
        try
        {
            $check_email = User::where(['email' => $request->email])->first();

            if(count($check_email) > 0)
            {
                $code = randomPassword::randomPassword(7);
                $user_id = $check_email->user_id;

                $data = [
                    'fname' => $check_email->fname,
                    'lname' => $check_email->lname,
                    'email' => $request->email,
                    'code' => $code
                ];

                \Mail::to($request->email)->send(new emailverify($data));

                $response = [
                    'msg' => "Verification Code is sent to your Email",
                    'status' => 1,
                    'code' => $code,
                    'user_id' => $user_id
                ];
            }
            else
            {
                $response = [
                    'msg' => "Invalid Email address",
                    'status' => 1
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

    public function verifycode(Request $request)
    {
        try
        {
            $check_code = User::where(['user_id' => $request->user_id])->first();

            $check_code->is_email_verify = 1;
            $check_code->save();

            $response = [
                'msg' => 'Email verification successful',
                'status' => 1
            ];
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

    public function mobileverify(Request $request)
    {
        try
        {
            $basic  = new \Nexmo\Client\Credentials\Basic(config('services.nexmo.key'), config('services.nexmo.secret'));
            $client = new \Nexmo\Client($basic);

            $otp = mt_rand(999,9999);

            $message = $client->message()->send([
                'to' => $request->phone,
                'from' => '+919727959595',
                'text' => "Your OTP for ExitVacancy App is ".$otp
            ]);

            $response = [
                'msg' => 'OTP sent to the user',
                'status' => 1,
                'OTP' => $otp
            ];
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

    public function verifyotp(Request $request)
    {
        try
        {
            $check_otp = User::where(['user_id' => $request->user_id])->first();

            $check_otp->is_mobile_verify = 1;
            $check_otp->save();

            $response = [
                'msg' => 'Mobile verification successful',
                'status' => 1
            ];            
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
