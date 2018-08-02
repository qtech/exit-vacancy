<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Bookings;
use App\Hoteldata;

class AppusersController extends Controller
{
    public function view()
    {
        $users = User::with('customer')->where(['role' => 2])->get();
        return view('appusers.main')->with('users', $users);
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
