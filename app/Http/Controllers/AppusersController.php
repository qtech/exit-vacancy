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
                $nobookings = User::with('customer')->where(['role' => 2,'bookings' => 0])->get();
                return view('appusers.main')->with('nobookings', $nobookings);
            }
            if($id == 2)
            {
                $b_thismonth = Bookings::with('customer','user')->groupBy('user_id')->get();
                return view('appusers.main')->with('b_thismonth', $b_thismonth);
            }
            if($id == 3)
            {
                $fivebookings = User::with('customer')->where('role','=', 2)->where('bookings','>', 5)->get();
                return view('appusers.main')->with('fivebookings', $fivebookings);
            }
            if($id == 4)
            {
                $r_thismonth = User::with('customer')->whereMonth('created_at', today()->format('m'))->get();
                return view('appusers.main')->with('r_thismonth', $r_thismonth);
            }
        }
        else
        {
            $users = User::with('customer')->where(['role' => 2])->get();
            return view('appusers.main')->with('users', $users);
        }   
           
    }

    public function user_bookings($id)
    {
        try
        {
            $userbookings = Bookings::where(['user_id' => $id])->get();
            return view('appusers.userbookings')->with('userbookings',$userbookings);
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }

    public function disable($id)
    {
        $disable = User::find($id);
        $disable->user_status = 0;
        $disable->save();
        return redirect()->route('appusers')->with('success', 'User disabled successfully');
    }

    public function enable($id)
    {
        $disable = User::find($id);
        $disable->user_status = 1;
        $disable->save();
        return redirect()->route('appusers')->with('success', 'User enabled successfully');
    }
}
