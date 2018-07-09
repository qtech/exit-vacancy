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
                $check_email->verify_code = $code;
                $check_email->save();

                $data = [
                    'fname' => $check_email->fname,
                    'lname' => $check_email->lname,
                    'email' => $request->email,
                    'code' => $code
                ];

                \Mail::to($request->email)->send(new emailverify($data));

                $response = [
                    'msg' => "Verification Code is sent to your Email",
                    'status' => 1
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
            $check_code = User::where(['email' => $request->email,'verify_code' => $request->code])->first();

            if(count($check_code) > 0)
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
                    'msg' => 'Your verification code is not valid',
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
}
