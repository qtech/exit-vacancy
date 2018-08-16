<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use App\Mail\emailverify;
use App\User;
use App\randomPassword;
use Twilio\Rest\Client;

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
                    'user_id' => $check_email->user_id
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
            // $basic  = new \Nexmo\Client\Credentials\Basic(config('services.nexmo.key'), config('services.nexmo.secret'));
            // $client = new \Nexmo\Client($basic);
            $check_number = User::with('customer','hotel')->find($request->user_id);
            if($check_number->role == 2 && $request->type == 2 && $check_number->customer->number == $request->phone)
            {
                $sid    = "AC852b54edaeb4579705126eb308c0c6e6";
                $token  = "580e851b75fad321439473c84ccd0145";
                $twilio = new Client($sid, $token);
    
                $otp = mt_rand(999,9999);
    
                $message = $twilio->messages->create('+'.$request->phone, // to
                    [
                        "body" => "Welcome to Exitvacancy! Your OTP is ".$otp,
                        "from" => "+16072149834"
                    ]
                );

                $response = [
                    'msg' => 'OTP sent to the user',
                    'status' => 1,
                    'OTP' => $otp
                ];
            }
            elseif($check_number->role == 3 && $request->type == 3 && $check_number->hotel->number == $request->phone)
            {
                $sid    = "AC852b54edaeb4579705126eb308c0c6e6";
                $token  = "580e851b75fad321439473c84ccd0145";
                $twilio = new Client($sid, $token);
    
                $otp = mt_rand(999,9999);
    
                $message = $twilio->messages->create('+'.$request->phone, // to
                    [
                        "body" => "Welcome to Exitvacancy! Your OTP is ".$otp,
                        "from" => "+16072149834"
                    ]
                );

                $response = [
                    'msg' => 'OTP sent to the user',
                    'status' => 1,
                    'OTP' => $otp
                ];
            }
            else
            {
                $response = [
                    'msg' => 'Please use the registered number',
                    'status' => 0,
                ];
            }
            // $message = $client->message()->send([
            //     'to' => $request->phone,
            //     'from' => '+919727959595',
            //     'text' => "Your OTP for ExitVacancy App is ".$otp
            // ]);
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
