<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Commission;

class AdmincommissionController extends Controller
{
    public function view()
    {
        try
        {
            $admin = Commission::find(1);
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
                'rate' => 'required',
                'bookings' => 'required',
                'commission_type' => 'required',
                'default_rate' => 'required',
                'default_commission_type' => 'required'
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
                $admin = Commission::find(1);
                $admin->bookings = $request->bookings;
                $admin->commission_type = $request->commission_type;
                $admin->commission = $request->rate;
                $admin->default_commission_type = $request->default_commission_type;
                $admin->default_commission = $request->default_rate;
                $admin->save();

                $admin = Commission::find(1);

                $response = [
                    'msg' => 'Commission updated',
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
