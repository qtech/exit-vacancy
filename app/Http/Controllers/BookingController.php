<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Bookings;
use App\Hoteldata;

class BookingController extends Controller
{
    public function viewbookings_completed($id = NULL)
    {
        try
        {
            if($id)
            {
                if($id == 1)
                {
                    $bookings = Bookings::with('user','hotel')->where(['status' => 1, 'is_visited' => 1])->whereDay('created_at',today()->format('d'))->get();
                }   
                if($id == 2)
                {
                    $today = today();
                    $week = $today->modify('-7 days');
                    
                    $bookings = Bookings::with('user','hotel')->where(['status' => 1, 'is_visited' => 1])->whereBetween('created_at',[$week,today()])->get();
                }
                if($id == 3)
                {
                    $bookings = Bookings::with('user','hotel')->where(['status' => 1, 'is_visited' => 1])->whereMonth('created_at',today()->format('m'))->get();
                }
            }
            else
            {
                $bookings = Bookings::with('user','hotel')->where(['status' => 1, 'is_visited' => 1])->get();
            }
            
            $data = [
                'id' => $id,
                'bookings' => $bookings
            ];

            return view('bookings.completed.main')->with($data);
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }

    public function viewbookings_cancelled($id = NULL)
    {
        try
        {
            if($id)
            {
                if($id == 1)
                {
                    $bookings = Bookings::with('user','hotel')->where(['status' => 2])->whereDay('created_at',today()->format('d'))->get();
                }   
                if($id == 2)
                {
                    $today = today();
                    $week = $today->modify('-7 days');
                    
                    $bookings = Bookings::with('user','hotel')->where(['status' => 2])->whereBetween('created_at',[$week,today()])->get();
                }
                if($id == 3)
                {
                    $bookings = Bookings::with('user','hotel')->where(['status' => 2])->whereMonth('created_at',today()->format('m'))->get();
                }
            }
            else
            {
                $bookings = Bookings::with('user','hotel')->where(['status' => 2])->get();
            }
            
            $data = [
                'id' => $id,
                'bookings' => $bookings
            ];

            return view('bookings.cancelled.main')->with($data);
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }

    public function viewbookings_pending($id = NULL)
    {
        try
        {
            if($id)
            {
                if($id == 1)
                {
                    $bookings = Bookings::with('user','hotel')->where(['status' => 1, 'is_visited' => 0])->whereDay('created_at',today()->format('d'))->get();
                }   
                if($id == 2)
                {
                    $today = today();
                    $week = $today->modify('-7 days');
                    
                    $bookings = Bookings::with('user','hotel')->where(['status' => 1, 'is_visited' => 0])->whereBetween('created_at',[$week,today()])->get();
                }
                if($id == 3)
                {
                    $bookings = Bookings::with('user','hotel')->where(['status' => 1, 'is_visited' => 0])->whereMonth('created_at',today()->format('m'))->get();
                }
            }
            else
            {
                $bookings = Bookings::with('user','hotel')->where(['status' => 1, 'is_visited' => 0])->get();
            }
            
            $data = [
                'id' => $id,
                'bookings' => $bookings
            ];

            return view('bookings.pending.main')->with($data);
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }
}
