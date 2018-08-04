<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications;
use App\User;
use Validator;

class SMSController extends Controller
{
    public function user_view()
    {
        $sms = Notifications::where(['status' => 1, 'type' => 3])->get();
        return view('sms.main')->with('sms', $sms);
    }
    public function user_add($id = NULL)
    {
        if($id)
        {
            if($id == 1)
            {
                $users = User::with('customer')->where(['role' => 2,'bookings' => 0])->get();
                return view('sms.add')->with('users', $users);
            }
            if($id == 2)
            {
                $users = User::with('customer')->with(['bookings' => function($query){
                    return $query->whereMonth('created_at', today()->format('m'))->groupBy('user_id');
                }])->where(['role' => 2])->get();                
                
                return view('sms.add')->with('users', $users);
            }
            if($id == 3)
            {
                $users = User::with('customer')->where(['role' => 2])->where('bookings','>', 5)->get();
                return view('sms.add')->with('users', $users);
            }
            if($id == 4)
            {
                $users = User::with('customer')->where(['role' => 2])->whereMonth('created_at', today()->format('m'))->get();
                return view('sms.add')->with('users', $users);
            }
        }
        else
        {
            $users = User::with('customer')->where(['role' => 2])->get();
            return view('sms.add')->with('users', $users);
        }
    }

    public function user_send(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'message' => 'required',
                'sms' => 'required'
            ]);

            if($validator->fails())
            {
                $response = [
                    'msg' => 'Oops! Something is missing',
                    'status' => 0
                ];
            }
            else
            {
                $notification = new Notifications;
                $notification->message = $request->message;
                $notification->type = 3;
                $notification->status = 1;
                $notification->save();

                foreach($request->sms as $user)
                {
                    $count = User::find($user);
                }

                $response = [
                    'msg' => 'SMS Sent',
                    'status' => 1
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

    public function user_delete($id)
    {
        $delete = Notifications::find($id)->delete();
        return redirect()->route('sms')->with('success', 'Sent SMS deleted successfully');
    }

    public function hotel_view()
    {
        $sms = Notifications::where(['status' => 2, 'type' => 3])->get();
        return view('sms_hotel.main')->with('sms', $sms);
    }
    public function hotel_add()
    {
        return view('sms_hotel.add');
    }

    public function hotel_send(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'message' => 'required'
            ]);

            if($validator->fails())
            {
                $response = [
                    'msg' => 'Oops! Something is missing',
                    'status' => 0
                ];
            }
            else
            {
                $notification = new Notifications;
                $notification->message = $request->message;
                $notification->type = 3;
                $notification->status = 2;
                $notification->save();

                $users = User::where(['role' => 3])->get();
                
                if(count($users) > 0)
                {
                    foreach($users as $user)
                    {
                        
                    }
                }

                $response = [
                    'msg' => 'SMS sent',
                    'status' => 1
                ];
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

    public function hotel_delete($id)
    {
        $delete = Notifications::find($id)->delete();
        return redirect()->route('h.sms')->with('success', 'Sent SMS deleted successfully');
    }
}
