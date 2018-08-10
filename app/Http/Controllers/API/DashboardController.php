<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class DashboardController extends Controller
{
    public function chart_all_data()
    {
        try
        {
            $users = DB::table('users')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'),DB::raw('role'))->groupBy('date')->get();
            
            $dateLabel = ["2018-07-01","2018-07-14","2018-07-19"];
            $user = [0,5,3];
            $hotel = [0,2,1];
                      
            foreach($users as $value)
            {
                if($value->role == 2)
                {
                    array_push($user,$value->count);
                    array_push($dateLabel,$value->date);
                    array_push($hotel,0);
                }
                if($value->role == 3)
                {
                    array_push($hotel,$value->count);
                    array_push($dateLabel,$value->date);
                    array_push($user,0);
                }
            }
            
            $response = [
                'msg' => 'Registrations Day-wise',
                'status' => 1,
                'users' => $user,
                'hotels' => $hotel,
                'dateLabel' => $dateLabel
            ];
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

    public function r_data_with_dates(Request $request)
    {
        try
        {
            $dateLabel = [];
            $user = [];
            $hotel = [];

            $users = DB::table('users')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'),DB::raw('role'))->whereBetween('created_at',[$request->r_date1,$request->r_date2])->groupBy('date')->get();

            foreach($users as $value)
            {
                if($value->role == 2)
                {
                    array_push($user,$value->count);
                    array_push($dateLabel,$value->date);
                    array_push($hotel,0);
                }
                if($value->role == 3)
                {
                    array_push($hotel,$value->count);
                    array_push($dateLabel,$value->date);
                    array_push($user,0);
                }
            }

            $response = [
                'msg' => 'Registrations Day-wise',
                'status' => 1,
                'users' => $user,
                'hotels' => $hotel,
                'dateLabel' => $dateLabel
            ];   
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

    public function bookings_data()
    {
        try
        {
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'),DB::raw('is_visited'))->where(['status' => 1])->groupBy('date')->get();
            
            $dateLabel = ["2018-07-01","2018-07-14","2018-07-19"];
            $complete = [4,1,8];
            $pending = [0,2,1];

            foreach($bookings as $value)
            {
                if($value->is_visited == 1)
                {
                    array_push($complete,$value->count);
                    array_push($dateLabel,$value->date);
                    array_push($pending,0);
                }
                else
                {
                    array_push($pending,$value->count);
                    array_push($dateLabel,$value->date);
                    array_push($complete,0);
                }
            }

            $response = [
                'msg' => 'Bookings Day-wise',
                'status' => 1,
                'completed' => $complete,
                'pending' => $pending,
                'dateLabel' => $dateLabel
            ];
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

    public function b_data_with_dates(Request $request)
    {
        try
        {
            $dateLabel = [];
            $complete = [];
            $pending = [];

            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'),DB::raw('is_visited'))->where(['status' => 1])->whereBetween('created_at',[$request->b_date1,$request->b_date2])->groupBy('date')->get();
            
            foreach($bookings as $value)
            {
                if($value->is_visited == 1)
                {
                    array_push($complete,$value->count);
                    array_push($dateLabel,$value->date);
                    array_push($pending,0);
                }
                else
                {
                    array_push($pending,$value->count);
                    array_push($dateLabel,$value->date);
                    array_push($complete,0);
                }
            }

            $response = [
                'msg' => 'Bookings Day-wise',
                'status' => 1,
                'completed' => $complete,
                'pending' => $pending,
                'dateLabel' => $dateLabel
            ];  
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

    public function hotel_bookings_data()
    {
        try
        {
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'),DB::raw('hotel_owner_id'),DB::raw('status'))->groupBy('date')->get();
            
            $dateLabel = ["2018-07-01","2018-07-14","2018-07-19"];
            $complete = [4,1,8];
            $cancel = [0,2,1];

            foreach($bookings as $value)
            {
                if($value->hotel_owner_id == Auth()->user()->user_id && $value->status == 1)
                {
                    array_push($complete,$value->count);
                    array_push($dateLabel,$value->date);
                    array_push($cancel,0);
                }
                if($value->hotel_owner_id == Auth()->user()->user_id && $value->status == 2)
                {
                    array_push($cancel,$value->count);
                    array_push($dateLabel,$value->date);
                    array_push($complete,0);
                }
            }

            $response = [
                'msg' => 'Bookings Day-wise',
                'status' => 1,
                'completed' => $complete,
                'cancelled' => $cancel,
                'dateLabel' => $dateLabel
            ];
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

    public function h_data_with_dates(Request $request)
    {
        try
        {
            $dateLabel = [];
            $complete = [];
            $cancel = [];

            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'),DB::raw('hotel_owner_id'),DB::raw('status'))->whereBetween('created_at',[$request->h_date1,$request->h_date2])->groupBy('date')->get();
            
            foreach($bookings as $value)
            {
                if($value->hotel_owner_id == Auth()->user()->user_id && $value->status == 1)
                {
                    array_push($complete,$value->count);
                    array_push($dateLabel,$value->date);
                    array_push($cancel,0);
                }
                if($value->hotel_owner_id == Auth()->user()->user_id && $value->status == 2)
                {
                    array_push($cancel,$value->count);
                    array_push($dateLabel,$value->date);
                    array_push($complete,0);
                }
            }

            $response = [
                'msg' => 'Bookings Day-wise',
                'status' => 1,
                'completed' => $complete,
                'cancelled' => $cancel,
                'dateLabel' => $dateLabel
            ]; 
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
