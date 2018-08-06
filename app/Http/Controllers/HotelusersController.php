<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Hoteldata;

class HotelusersController extends Controller
{
    public function view()
    {
        try
        {
            $hotelusers = User::with('hotel','hotelbookings')->where(['role' => 3])->get();
            return view('hotelusers.main')->with('hotelusers', $hotelusers);
        }
        catch(\Exception $e)
        {
            return $e->getMessage." ".$e->getLine();
        }
    }   

    public function hotel_user_details($id)
    {
        try
        {
            $details = Hoteldata::where(['user_id' => $id])->get();
            return view('hotelusers.viewdetails')->with('details', $details);
        }
        catch(\Exception $e)
        {
            return $e->getMessage." ".$e->getLine();
        }
    }
}
