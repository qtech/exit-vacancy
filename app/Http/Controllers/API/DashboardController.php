<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function chart_all_data()
    {
        try
        {
            $present = Carbon::now();
            $past = Carbon::now()->subMonth()->toDateString();

            $date_from = strtotime($past); // Convert date to a UNIX timestamp  
  
            // Specify the end date. This date can be any English textual format  
            $date_to = strtotime($present); // Convert date to a UNIX timestamp  
            
            $dates = [];

            // Loop from the start date to end date and output all dates inbetween  
            for ($i=$date_from; $i<=$date_to; $i+=86400) {  
                array_push($dates,date("Y-m-d", $i));  
            }

            $users = DB::table('users')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'),DB::raw('role'))->where('role','!=',1)->groupBy('date')->get();
            
            $hotel = [];
            $user = [];
            $dateLabel = [];
            
            foreach($dates as $k => $value)
            {
                foreach($users as $u)
                {
                    if($u->date == $value)
                    {
                        if($u->role == 2)
                        {
                            array_push($user,$u->count);
                            array_push($dateLabel,$u->date);
                            array_push($hotel,0);
                        }
                        else
                        {
                            array_push($hotel,$u->count);
                            array_push($dateLabel,$u->date);
                            array_push($user,0);
                        }
                    }
                    else
                    {
                        array_push($hotel,0);
                        array_push($dateLabel,$value);
                        array_push($user,0);
                    }
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
            $date_from = strtotime($request->r_date1); // Convert date to a UNIX timestamp  
  
            // Specify the end date. This date can be any English textual format  
            $date_to = strtotime($request->r_date2); // Convert date to a UNIX timestamp  
            
            $dates = [];

            // Loop from the start date to end date and output all dates inbetween  
            for ($i=$date_from; $i<=$date_to; $i+=86400) {  
                array_push($dates,date("Y-m-d", $i));  
            }

            $dateLabel = [];
            $user = [];
            $hotel = [];

            $users = DB::table('users')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'),DB::raw('role'))->whereBetween('created_at',[$request->r_date1,$request->r_date2])->groupBy('date')->get();

            foreach($dates as $k => $value)
            {
                foreach($users as $u)
                {
                    if($u->date == $value)
                    {
                        if($u->role == 2)
                        {
                            array_push($user,$u->count);
                            array_push($dateLabel,$u->date);
                            array_push($hotel,0);
                        }
                        else
                        {
                            array_push($hotel,$u->count);
                            array_push($dateLabel,$u->date);
                            array_push($user,0);
                        }
                    }
                    else
                    {
                        array_push($hotel,0);
                        array_push($dateLabel,$value);
                        array_push($user,0);
                    }
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
            $present = Carbon::now();
            $past = Carbon::now()->subMonth()->toDateString();

            $date_from = strtotime($past); // Convert date to a UNIX timestamp  
  
            // Specify the end date. This date can be any English textual format  
            $date_to = strtotime($present); // Convert date to a UNIX timestamp  
            
            $dates = [];

            // Loop from the start date to end date and output all dates inbetween  
            for ($i=$date_from; $i<=$date_to; $i+=86400) {  
                array_push($dates,date("Y-m-d", $i));  
            }

            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'),DB::raw('is_visited'))->where(['status' => 1])->groupBy('date')->get();
            
            $dateLabel = [];
            $complete = [];
            $pending = [];

            foreach($dates as $k => $value)
            {
                foreach($bookings as $b)
                {
                    if($b->date == $value)
                    {
                        if($b->is_visited == 1)
                        {
                            array_push($complete,$b->count);
                            array_push($dateLabel,$b->date);
                            array_push($pending,0);
                        }
                        else
                        {
                            array_push($pending,$b->count);
                            array_push($dateLabel,$b->date);
                            array_push($complete,0);
                        }
                    }
                    else
                    {
                        array_push($pending,0);
                        array_push($dateLabel,$value);
                        array_push($complete,0);
                    }
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
            $date_from = strtotime($request->b_date1); // Convert date to a UNIX timestamp  
  
            // Specify the end date. This date can be any English textual format  
            $date_to = strtotime($request->b_date2); // Convert date to a UNIX timestamp  
            
            $dates = [];

            // Loop from the start date to end date and output all dates inbetween  
            for ($i=$date_from; $i<=$date_to; $i+=86400) {  
                array_push($dates,date("Y-m-d", $i));  
            }

            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'),DB::raw('is_visited'))->where(['status' => 1])->whereBetween('created_at',[$request->b_date1,$request->b_date2])->groupBy('date')->get();
            
            $dateLabel = [];
            $complete = [];
            $pending = [];

            foreach($dates as $k => $value)
            {
                foreach($bookings as $b)
                {
                    if($b->date == $value)
                    {
                        if($b->is_visited == 1)
                        {
                            array_push($complete,$b->count);
                            array_push($dateLabel,$b->date);
                            array_push($pending,0);
                        }
                        else
                        {
                            array_push($pending,$b->count);
                            array_push($dateLabel,$b->date);
                            array_push($complete,0);
                        }
                    }
                    else
                    {
                        array_push($pending,0);
                        array_push($dateLabel,$value);
                        array_push($complete,0);
                    }
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

    public function practice_code()
    {
            //$begin = new DateTime( '2018-07-01' ); 
            // $end = new DateTime( '2018-08-10' );
            // $end = $end->modify( '+1 day' ); 
            // $interval = new DateInterval('P1D');
            // $daterange = new DatePeriod($begin, $interval ,$end);

            // $present = Carbon::now();
            // $past = Carbon::now()->subMonth()->toDateString();
            // $begin = new DateTime( $present ); 
            // $end = new DateTime( $past );
            // $interval = new DateInterval('P1D');
            // $daterange = new DatePeriod($begin, $interval ,$end);

            // foreach($daterange as $date){
            //     array_push($dates,$date->format('Y-m-d'));
            // }
    }
}
