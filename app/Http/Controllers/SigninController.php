<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

class SigninController extends Controller
{
    public function view()
    {
        return view('login.main');
    }

    public function checkLogin(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'uname' => 'required',
                'password' => 'required'
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
                if(Auth::attempt(['fname' => $request->uname, 'password' => $request->password, 'role' => 1]))
                {
                    $response = [
                        'msg' => 'Login Successful',
                        'status' => 1
                    ];
                }
                else
                {
                    $response = [
                        'msg' => 'Invalid Credentials',
                        'status' => 0
                    ];
                }
            }
        }
        catch(\Exception $e)
        {
            $response = [
                'msg' => $e->getMessage()."".$e->getLine(),
                'status' => 0
            ];
        }
        return response()->json($response);
    }
}
