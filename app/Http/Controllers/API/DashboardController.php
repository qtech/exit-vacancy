<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function user_registration_chart()
    {
        try
        {
            // $date_from = strtotime($past); // Convert date to a UNIX timestamp  
  
            // // Specify the end date. This date can be any English textual format  
            // $date_to = strtotime($present); // Convert date to a UNIX timestamp  
            
            // $dates = [];

            // // Loop from the start date to end date and output all dates inbetween  
            // for ($i=$date_from; $i<=$date_to; $i+=86400) {  
            //     array_push($dates,date("Y-m-d", $i));  
            // }

            // foreach($dates as $k => $value)
            // {
            //     foreach($users as $u)
            //     {
            //         if($u->date == $value)
            //         {
            //             array_push($dateLabel,$value);
            //             array_push($user,$u->count);
            //         }
            //         else
            //         {
            //             array_push($dateLabel,$value);
            //             array_push($user,0);
            //         }
            //     }                                   
            // }

            $present = Carbon::now();
            $past = Carbon::now()->subMonth()->toDateString();

            $users = DB::table('users')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where('role','=','2')->whereBetween('created_at',[$past,$present])->groupBy('date')->get();

            $user = [1,3,7,2,8,5];
            $dateLabel = ["2018-08-10","2018-08-12","2018-08-15","2018-08-18","2018-08-20","2018-08-23"];

            foreach($users as $value)
            {
                array_push($dateLabel,$value->date);
                array_push($user,$value->count);
            }

            $response = [
                'msg' => 'User Registrations Day-wise',
                'status' => 1,
                'users' => $user,
                'dateLabel' => $dateLabel
            ];
        }
        catch(\Exception $e)
        {
            $response = [
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }

    public function hotel_registration_chart()
    {
        try
        {
            $present = Carbon::now();
            $past = Carbon::now()->subMonth()->toDateString();

            $hotels = DB::table('users')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where('role','=','3')->whereBetween('created_at',[$past,$present])->groupBy('date')->get();

            $hotel = [1,3,3,9,2,5];
            $dateLabel = ["2018-08-10","2018-08-12","2018-08-15","2018-08-18","2018-08-20","2018-08-23"];

            foreach($hotels as $value)
            {
                array_push($dateLabel,$value->date);
                array_push($hotel,$value->count);
            }

            $response = [
                'msg' => 'Hotel Registrations Day-wise',
                'status' => 1,
                'hotels' => $hotel,
                'dateLabel' => $dateLabel
            ];
        }
        catch(\Exception $e)
        {
            $response = [
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }

    public function completed_bookings()
    {
        try
        {
            $present = Carbon::now();
            $past = Carbon::now()->subMonth()->toDateString();
                
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1,'is_visited' => 1])->groupBy('date')->get();
            
            $dateLabel = ["2018-08-10","2018-08-12","2018-08-15","2018-08-18","2018-08-20","2018-08-23"];
            $completed = [1,0,5,3,10,8];

            foreach($bookings as $value)
            {
                array_push($dateLabel,$value->date);
                array_push($completed,$value->count);
            }

            $response = [
                'msg' => 'User Bookings',
                'status' => 1,
                'completed' => $completed,
                'dateLabel' => $dateLabel
            ];
        }
        catch(\Exception $e)
        {   
            $response = [
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }

    public function pending_bookings()
    {
        try
        {
            $present = Carbon::now();
            $past = Carbon::now()->subMonth()->toDateString();
                
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1,'is_visited' => 0])->groupBy('date')->get();
            
            $dateLabel = ["2018-08-10","2018-08-12","2018-08-15","2018-08-18","2018-08-20","2018-08-23"];
            $pending = [5,1,3,7,2,4];

            foreach($bookings as $value)
            {
                array_push($dateLabel,$value->date);
                array_push($pending,$value->count);
            }

            $response = [
                'msg' => 'User Bookings',
                'status' => 1,
                'pending' => $pending,
                'dateLabel' => $dateLabel
            ];
        }
        catch(\Exception $e)
        {   
            $response = [
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }

    public function cancelled_bookings()
    {
        try
        {
            $present = Carbon::now();
            $past = Carbon::now()->subMonth()->toDateString();
                
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 2])->groupBy('date')->get();
            
            $dateLabel = ["2018-08-10","2018-08-12","2018-08-15","2018-08-18","2018-08-20","2018-08-23"];
            $cancelled = [2,1,3,0,2,1];

            foreach($bookings as $value)
            {
                array_push($dateLabel,$value->date);
                array_push($cancelled,$value->count);
            }

            $response = [
                'msg' => 'User Bookings',
                'status' => 1,
                'cancelled' => $cancelled,
                'dateLabel' => $dateLabel
            ];
        }
        catch(\Exception $e)
        {   
            $response = [
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }

    public function u_r_data_with_dates(Request $request)
    {
        try
        {
            $users = DB::table('users')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where('role','=','2')->whereBetween('created_at',[$request->u_r_date1,$request->u_r_date2])->groupBy('date')->get();
            
            $user = [];
            $dateLabel = [];

            foreach($users as $value)
            {
                array_push($dateLabel,$value->date);
                array_push($user,$value->count);
            }

            $response = [
                'msg' => 'Registrations Day-wise',
                'status' => 1,
                'users' => $user,
                'dateLabel' => $dateLabel
            ]; 
        }
        catch(\Exception $e)
        {
            $response = [
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }

    public function h_r_data_with_dates(Request $request)
    {
        try
        {
            $hotels = DB::table('users')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where('role','=','3')->whereBetween('created_at',[$request->h_r_date1,$request->h_r_date2])->groupBy('date')->get();
            
            $hotel = [];
            $dateLabel = [];

            foreach($hotels as $value)
            {
                array_push($dateLabel,$value->date);
                array_push($hotel,$value->count);
            }

            $response = [
                'msg' => 'Registrations Day-wise',
                'status' => 1,
                'hotels' => $hotel,
                'dateLabel' => $dateLabel
            ]; 
        }
        catch(\Exception $e)
        {
            $response = [
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }

    public function cb_data_with_dates(Request $request)
    {
        try
        {
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1, 'is_visited' => 1])->whereBetween('created_at',[$request->c_b_date1,$request->c_b_date2])->groupBy('date')->get();
            
            $dateLabel = [];
            $completed = [];

            foreach($bookings as $value)
            {
                array_push($dateLabel,$value->date);
                array_push($completed,$value->count);
            }

            $response = [
                'msg' => 'User Bookings',
                'status' => 1,
                'completed' => $completed,
                'dateLabel' => $dateLabel
            ];
        }
        catch(\Exception $e)
        {
            $response = [
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }

    public function pb_data_with_dates(Request $request)
    {
        try
        {
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1, 'is_visited' => 0])->whereBetween('created_at',[$request->p_b_date1,$request->p_b_date2])->groupBy('date')->get();
            
            $dateLabel = [];
            $pending = [];

            foreach($bookings as $value)
            {
                array_push($dateLabel,$value->date);
                array_push($pending,$value->count);
            }

            $response = [
                'msg' => 'User Bookings',
                'status' => 1,
                'pending' => $pending,
                'dateLabel' => $dateLabel
            ];
        }
        catch(\Exception $e)
        {
            $response = [
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }

    public function can_data_with_dates(Request $request)
    {
        try
        {
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 2])->whereBetween('created_at',[$request->can_b_date1,$request->can_b_date2])->groupBy('date')->get();
            
            $dateLabel = [];
            $cancelled = [];

            foreach($bookings as $value)
            {
                array_push($dateLabel,$value->date);
                array_push($cancelled,$value->count);
            }

            $response = [
                'msg' => 'User Bookings',
                'status' => 1,
                'cancelled' => $cancelled,
                'dateLabel' => $dateLabel
            ];
        }
        catch(\Exception $e)
        {
            $response = [
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
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
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
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
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
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
