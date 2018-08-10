<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

class SigninController extends Controller
{
    public function view()
    {
        return view('login.view');
    }

    public function checkLogin(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'email' => 'required',
                'password' => 'required'
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
                if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
                {
                    if(Auth()->user()->role == 1)
                    {
                        $response = [
                            'msg' => 'Welcome Admin',
                            'status' => 1
                        ];
                    }
                    else
                    {
                        $response = [
                            'msg' => 'Welcome Hotel Owner',
                            'status' => 2
                        ];
                    }
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

    public function logout()
    {
        try
        {
            Auth::logout();
            return redirect()->route('login')->with('success', 'Logout Successful');
        }
        catch(\Exception $e)
        {
            $response = [
                'msg' => $e->getMessage()."".$e->getLine(),
                'status' => 0
            ];
            
            return response()->json($response);
        }
    }
}
