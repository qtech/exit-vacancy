<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use App\Mail\emailverify;
use App\User;
use Validator;
use App\randomPassword;
use Twilio\Rest\Client;
use App\Hoteldata;
use App\Customer;

class verificationController extends Controller
{
    public function emailverify(Request $request)
    {
        try
        {
            $check_email = User::where(['email' => $request->email])->first();

            if($check_email)
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
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
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

            if($check_code)
            {
                $check_code->is_email_verify = 1;
                $check_code->save();

                $response = [
                    'msg' => 'Email verification successful',
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
        catch(\Exception $e)
        {
            $response = [
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
                'status' => 0
            ];
        }
        return response()->json($response);
    }

    public function mobileverify(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'phone' => 'required',
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
                    // $basic  = new \Nexmo\Client\Credentials\Basic(config('services.nexmo.key'), config('services.nexmo.secret'));
                    // $client = new \Nexmo\Client($basic);
                    if($request->type == 2)
                    {
                        $check = Customer::where(['number' => $request->phone])->first();
                        if($check)
                        {
                            $response = [
                                'msg' => 'This number is already registered by other user',
                                'status' => 0
                            ];
                        }
                        else
                        {
                            $addnumber = Customer::where(['user_id' => $request->user_id])->first();
                            $addnumber->number = $request->phone;
                            $addnumber->save();
            
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
                    }
        
                    if($request->type == 3)
                    {
                        $check = Hoteldata::where(['number' => $request->phone])->first();
                        if($check)
                        {
                            $response = [
                                'msg' => 'This number is already registered by other user',
                                'status' => 0
                            ];
                        }
                        else
                        {
                            $addnumber = Hoteldata::where(['user_id' => $request->user_id])->first();
                            $addnumber->number = $request->phone;
                            $addnumber->save();
            
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
                    }
                    
                    // $message = $client->message()->send([
                    //     'to' => $request->phone,
                    //     'from' => '+919727959595',
                    //     'text' => "Your OTP for ExitVacancy App is ".$otp
                    // ]);
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

    public function resend_mobileverify(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'user_id' => 'required',
                'phone' => 'required'
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
                // $basic  = new \Nexmo\Client\Credentials\Basic(config('services.nexmo.key'), config('services.nexmo.secret'));
                // $client = new \Nexmo\Client($basic);

                if($request->type == 2)
                {
                    $checknumber = Customer::where(['user_id' => $request->user_id,'number' => $request->phone])->first();

                    if($checknumber)
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
                            'msg' => 'Please enter the registered number.',
                            'status' => 0
                        ];
                    }
                }

                if($request->type == 3)
                {
                    $checknumber = Hoteldata::where(['user_id' => $request->user_id,'number' => $request->phone])->first();

                    if($checknumber)
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
                            'msg' => 'Please enter the registered number.',
                            'status' => 0
                        ];
                    }
                }
                
                // $message = $client->message()->send([
                //     'to' => $request->phone,
                //     'from' => '+919727959595',
                //     'text' => "Your OTP for ExitVacancy App is ".$otp
                // ]);
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

    public function verifyotp(Request $request)
    {
        try
        {
            $check_otp = User::where(['user_id' => $request->user_id])->first();

            if($check_otp)
            {
                $check_otp->is_mobile_verify = 1;
                $check_otp->save();
    
                $response = [
                    'msg' => 'Mobile verification successful',
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
