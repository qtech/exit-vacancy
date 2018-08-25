<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Bookings;
use App\Hoteldata;

class AppusersController extends Controller
{
    public function view_allusers($id = NULL)
    {
        if($id)
        {
            if($id == 1)
            {
                $users = User::with('customer','userbookings')->where(['role' => 2,'bookings' => 0])->get();
            }
            if($id == 2)
            {
                $temp = User::with('customer')->with(['userbookings' => function($query){
                    return $query->whereMonth('created_at', today()->format('m'))->groupBy('user_id');
                }])->where(['role' => 2])->get();  
            
                $users = [];
                foreach($temp as $tmp)
                {
                    if(count($tmp->userbookings) > 0)
                    {
                        array_push($users,$tmp);
                    }
                }
            }
            if($id == 3)
            {
                $users = User::with('customer','userbookings')->where(['role' => 2])->where('bookings','>', 5)->get();
            }
            if($id == 4)
            {
                $users = User::with('customer','userbookings')->where(['role' => 2])->whereMonth('created_at', today()->format('m'))->get();
            }
        }
        else
        {
            $users = User::with('customer','userbookings')->where(['role' => 2])->get();
        } 
        $data = [
            'id' => $id,
            'users' => $users
        ];
        
        return view('appusers.main')->with($data);
    }

    public function user_bookings($id)
    {
        try
        {
            $data = [
                'bookings' => Bookings::with('hotel')->where(['user_id' => $id])->get(),
                'user' => User::with('customer')->where(['user_id' => $id])->first(),
            ];

            return view('appusers.userprofile')->with($data);
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }

    public function userdisable($id)
    {
        $disable = User::find($id);
        $disable->user_status = 0;
        $disable->save();
        return redirect()->route('appusers')->with('success', 'User disabled successfully');
    }

    public function userenable($id)
    {
        $disable = User::find($id);
        $disable->user_status = 1;
        
        $disable->save();
        return redirect()->route('appusers')->with('success', 'User enabled successfully');
    }

    public function hoteldisable($id)
    {
        $disable = User::find($id);
        $disable->user_status = 0;
        $disable->save();
        $disable_hotel = Hoteldata::where(['user_id' => $id])->first();
        $disable_hotel->status = 0;
        $disable_hotel->save();
        return redirect()->route('hotelusers')->with('success', 'Hotel disabled successfully');
    }

    public function hotelenable($id)
    {
        $disable = User::find($id);
        $disable->user_status = 1;
        $disable->save();
        $disable_hotel = Hoteldata::where(['user_id' => $id])->first();
        $disable_hotel->status = 1;
        $disable_hotel->save();
        return redirect()->route('hotelusers')->with('success', 'Hotel enabled successfully');
    }
}
