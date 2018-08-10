<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;

class AdmincommissionController extends Controller
{
    public function view()
    {
        try
        {
            $admin = User::find(1);
            return view('commission.main')->with('admin', $admin);
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }

    public function update(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'rate' => 'required'
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
                $admin = User::find(1);
                $admin->lname = $request->rate;
                $admin->save();

                $admin = User::find(1);

                $response = [
                    'msg' => 'Commission percentage updated',
                    'status' => 1,
                    'data' => $admin
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
