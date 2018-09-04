<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bookings;
use DB;
use Carbon\Carbon;

class ChartbookingsController extends Controller
{
    public function all_completed()
    {
        try
        {
            // $present = Carbon::now();
            // $past = Carbon::now()->subMonth()->toDateString();

            // $date_from = strtotime($past); // Convert date to a UNIX timestamp  
  
            // // Specify the end date. This date can be any English textual format  
            // $date_to = strtotime($present); // Convert date to a UNIX timestamp  
            
            // $dates = [];

            // // Loop from the start date to end date and output all dates inbetween  
            // for ($i=$date_from; $i<=$date_to; $i+=86400) {  
            //     array_push($dates,date("Y-m-d", $i));  
            // }

            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1, 'is_visited' => 1])->groupBy('date')->get();
            
            $dateLabel = ["2018-08-10","2018-08-12","2018-08-15","2018-08-18","2018-08-20","2018-08-23"];
            $booking = [2,5,3,7,8,1];

            foreach($bookings as $b)
            {
                array_push($booking,$b->count);
                array_push($dateLabel,$b->date);
            }                                   

            $response = [
                'msg' => 'Bookings Day-wise',
                'status' => 1,
                'bookings' => $booking,
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

    public function today_completed()
    {
        try
        {
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1, 'is_visited' => 1])->whereDay('created_at',today()->format('d'))->groupBy('date')->get();
            
            $dateLabel = [];
            $booking = [];

            foreach($bookings as $value)
            {
                array_push($booking,$value->count);
                array_push($dateLabel,$value->date);
            }

            $response = [
                'msg' => 'Bookings Day-wise',
                'status' => 1,
                'bookings' => $booking,
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

    public function week_completed()
    {
        try
        {
            $present = Carbon::now();
            $past = Carbon::now()->subDays(6)->toDateString();

            // $date_from = strtotime($past); // Convert date to a UNIX timestamp  
  
            // // Specify the end date. This date can be any English textual format  
            // $date_to = strtotime($present); // Convert date to a UNIX timestamp  
            
            // $dates = [];

            // // Loop from the start date to end date and output all dates inbetween  
            // for ($i=$date_from; $i<=$date_to; $i+=86400) {  
            //     array_push($dates,date("Y-m-d", $i));  
            // }

            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1, 'is_visited' => 1])->whereBetween('created_at',[$past,$present])->groupBy('date')->get();
            
            $dateLabel = ["2018-08-18","2018-08-20","2018-08-23"];
            $booking = [1,3,9];

            foreach($bookings as $b)
            {
                array_push($booking,$b->count);
                array_push($dateLabel,$b->date);
            }                                   
            

            $response = [
                'msg' => 'Bookings Day-wise',
                'status' => 1,
                'bookings' => $booking,
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

    public function month_completed()
    {
        try
        {
            // $first_day = Carbon::now()->startOfMonth();
            // $last_day = Carbon::now()->endOfMonth();

            // $date_from = strtotime($first_day); // Convert date to a UNIX timestamp  
  
            // // Specify the end date. This date can be any English textual format  
            // $date_to = strtotime($last_day); // Convert date to a UNIX timestamp  
            
            // $dates = [];

            // // Loop from the start date to end date and output all dates inbetween  
            // for ($i=$date_from; $i<=$date_to; $i+=86400) {  
            //     array_push($dates,date("Y-m-d", $i));  
            // }

            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1, 'is_visited' => 1])->whereMonth('created_at',today()->format('m'))->groupBy('date')->get();
            
            $dateLabel = ["2018-08-10","2018-08-12","2018-08-15","2018-08-18","2018-08-20","2018-08-23"];
            $booking = [5,1,8,3,2,0];

            foreach($bookings as $b)
            {
                array_push($booking,$b->count);
                array_push($dateLabel,$b->date);
            }                                   

            $response = [
                'msg' => 'Bookings Day-wise',
                'status' => 1,
                'bookings' => $booking,
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

    public function dates_completed(Request $request)
    {
        try
        {
            // $date_from = strtotime($request->b_date1); // Convert date to a UNIX timestamp  
  
            // // Specify the end date. This date can be any English textual format  
            // $date_to = strtotime($request->b_date2); // Convert date to a UNIX timestamp  
            
            // $dates = [];

            // // Loop from the start date to end date and output all dates inbetween  
            // for ($i=$date_from; $i<=$date_to; $i+=86400) {  
            //     array_push($dates,date("Y-m-d", $i));  
            // }

            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1, 'is_visited' => 1])->whereBetween('created_at',[$request->b_date1,$request->b_date2])->groupBy('date')->get();
            
            $dateLabel = [];
            $booking = [];

            foreach($bookings as $b)
            {
                array_push($booking,$b->count);
                array_push($dateLabel,$b->date);
            }                                   

            $response = [
                'msg' => 'Bookings Day-wise',
                'status' => 1,
                'bookings' => $booking,
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

    public function all_pending()
    {
        try
        {
            // $present = Carbon::now();
            // $past = Carbon::now()->subMonth()->toDateString();

            // $date_from = strtotime($past); // Convert date to a UNIX timestamp  
  
            // // Specify the end date. This date can be any English textual format  
            // $date_to = strtotime($present); // Convert date to a UNIX timestamp  
            
            // $dates = [];

            // // Loop from the start date to end date and output all dates inbetween  
            // for ($i=$date_from; $i<=$date_to; $i+=86400) {  
            //     array_push($dates,date("Y-m-d", $i));  
            // }

            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1, 'is_visited' => 0])->groupBy('date')->get();
            
            $dateLabel = ["2018-08-10","2018-08-12","2018-08-15","2018-08-18","2018-08-20","2018-08-23"];
            $booking = [6,2,4,1,0,4];

            foreach($bookings as $b)
            {
                array_push($booking,$b->count);
                array_push($dateLabel,$b->date);
            }                                   

            $response = [
                'msg' => 'Bookings Day-wise',
                'status' => 1,
                'bookings' => $booking,
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

    public function today_pending()
    {
        try
        {
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1, 'is_visited' => 0])->whereDay('created_at',today()->format('d'))->groupBy('date')->get();
            
            $dateLabel = [];
            $booking = [];

            foreach($bookings as $value)
            {
                array_push($booking,$value->count);
                array_push($dateLabel,$value->date);
            }

            $response = [
                'msg' => 'Bookings Day-wise',
                'status' => 1,
                'bookings' => $booking,
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

    public function week_pending()
    {
        try
        {
            $present = Carbon::now();
            $past = Carbon::now()->subDays(6)->toDateString();

            // $date_from = strtotime($past); // Convert date to a UNIX timestamp  
  
            // // Specify the end date. This date can be any English textual format  
            // $date_to = strtotime($present); // Convert date to a UNIX timestamp  
            
            // $dates = [];

            // // Loop from the start date to end date and output all dates inbetween  
            // for ($i=$date_from; $i<=$date_to; $i+=86400) {  
            //     array_push($dates,date("Y-m-d", $i));  
            // }
            
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1, 'is_visited' => 0])->whereBetween('created_at',[$past,$present])->groupBy('date')->get();
            
            $dateLabel = ["2018-08-18","2018-08-20","2018-08-23"];
            $booking = [2,7,1];

            foreach($bookings as $b)
            {
                array_push($booking,$b->count);
                array_push($dateLabel,$b->date);
            }                                   

            $response = [
                'msg' => 'Bookings Day-wise',
                'status' => 1,
                'bookings' => $booking,
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

    public function month_pending()
    {
        try
        {
            // $first_day = Carbon::now()->startOfMonth();
            // $last_day = Carbon::now()->endOfMonth();

            // $date_from = strtotime($first_day); // Convert date to a UNIX timestamp  
  
            // // Specify the end date. This date can be any English textual format  
            // $date_to = strtotime($last_day); // Convert date to a UNIX timestamp  
            
            // $dates = [];

            // // Loop from the start date to end date and output all dates inbetween  
            // for ($i=$date_from; $i<=$date_to; $i+=86400) {  
            //     array_push($dates,date("Y-m-d", $i));  
            // }

            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1, 'is_visited' => 0])->whereMonth('created_at',today()->format('m'))->groupBy('date')->get();
            
            $dateLabel = ["2018-08-10","2018-08-12","2018-08-15","2018-08-18","2018-08-20","2018-08-23"];
            $booking = [3,12,3,0,6,4];

            foreach($bookings as $b)
            {
                array_push($booking,$b->count);
                array_push($dateLabel,$b->date);
            }                                   

            $response = [
                'msg' => 'Bookings Day-wise',
                'status' => 1,
                'bookings' => $booking,
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

    public function dates_pending(Request $request)
    {
        try
        {
            // $date_from = strtotime($request->b_date1); // Convert date to a UNIX timestamp  
  
            // // Specify the end date. This date can be any English textual format  
            // $date_to = strtotime($request->b_date2); // Convert date to a UNIX timestamp  
            
            // $dates = [];

            // // Loop from the start date to end date and output all dates inbetween  
            // for ($i=$date_from; $i<=$date_to; $i+=86400) {  
            //     array_push($dates,date("Y-m-d", $i));  
            // }

            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1, 'is_visited' => 0])->whereBetween('created_at',[$request->b_date1,$request->b_date2])->groupBy('date')->get();
            
            $dateLabel = [];
            $booking = [];

            foreach($bookings as $b)
            {
                array_push($booking,$b->count);
                array_push($dateLabel,$b->date);
            }                                   

            $response = [
                'msg' => 'Bookings Day-wise',
                'status' => 1,
                'bookings' => $booking,
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

    public function all_cancelled()
    {
        try
        {
            // $present = Carbon::now();
            // $past = Carbon::now()->subMonth()->toDateString();

            // $date_from = strtotime($past); // Convert date to a UNIX timestamp  
  
            // // Specify the end date. This date can be any English textual format  
            // $date_to = strtotime($present); // Convert date to a UNIX timestamp  
            
            // $dates = [];

            // // Loop from the start date to end date and output all dates inbetween  
            // for ($i=$date_from; $i<=$date_to; $i+=86400) {  
            //     array_push($dates,date("Y-m-d", $i));  
            // }

            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 2])->groupBy('date')->get();
            
            $dateLabel = ["2018-08-10","2018-08-12","2018-08-15","2018-08-18","2018-08-20","2018-08-23"];
            $booking = [4,8,1,3,2,0];

            foreach($bookings as $b)
            {
                array_push($booking,$b->count);
                array_push($dateLabel,$b->date);
            }                                   

            $response = [
                'msg' => 'Bookings Day-wise',
                'status' => 1,
                'bookings' => $booking,
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

    public function today_cancelled()
    {
        try
        {
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 2])->whereDay('created_at',today()->format('d'))->groupBy('date')->get();
            
            $dateLabel = [];
            $booking = [];

            foreach($bookings as $b)
            {
                array_push($booking,$b->count);
                array_push($dateLabel,$b->date);
            }                                   

            $response = [
                'msg' => 'Bookings Day-wise',
                'status' => 1,
                'bookings' => $booking,
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

    public function week_cancelled()
    {
        try
        {
            $present = Carbon::now();
            $past = Carbon::now()->subDays(6)->toDateString();

            // $date_from = strtotime($past); // Convert date to a UNIX timestamp  
  
            // // Specify the end date. This date can be any English textual format  
            // $date_to = strtotime($present); // Convert date to a UNIX timestamp  
            
            // $dates = [];

            // // Loop from the start date to end date and output all dates inbetween  
            // for ($i=$date_from; $i<=$date_to; $i+=86400) {  
            //     array_push($dates,date("Y-m-d", $i));  
            // }

            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 2])->whereBetween('created_at',[$past,$present])->groupBy('date')->get();
            
            $dateLabel = ["2018-08-18","2018-08-20","2018-08-23"];
            $booking = [1,4,2];

            foreach($bookings as $b)
            {
                array_push($booking,$b->count);
                array_push($dateLabel,$b->date);
            }                                   

            $response = [
                'msg' => 'Bookings Day-wise',
                'status' => 1,
                'bookings' => $booking,
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

    public function month_cancelled()
    {
        try
        {
            // $first_day = Carbon::now()->startOfMonth();
            // $last_day = Carbon::now()->endOfMonth();

            // $date_from = strtotime($first_day); // Convert date to a UNIX timestamp  
  
            // // Specify the end date. This date can be any English textual format  
            // $date_to = strtotime($last_day); // Convert date to a UNIX timestamp  
            
            // $dates = [];

            // // Loop from the start date to end date and output all dates inbetween  
            // for ($i=$date_from; $i<=$date_to; $i+=86400) {  
            //     array_push($dates,date("Y-m-d", $i));  
            // }

            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 2])->whereMonth('created_at',today()->format('m'))->groupBy('date')->get();
            
            $dateLabel = ["2018-08-10","2018-08-12","2018-08-15","2018-08-18","2018-08-20","2018-08-23"];
            $booking = [3,7,1,2,4,7];

            foreach($bookings as $b)
            {
                array_push($booking,$b->count);
                array_push($dateLabel,$b->date);
            }                                   

            $response = [
                'msg' => 'Bookings Day-wise',
                'status' => 1,
                'bookings' => $booking,
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

    public function dates_cancelled(Request $request)
    {
        try
        {
            // $date_from = strtotime($request->b_date1); // Convert date to a UNIX timestamp  
  
            // // Specify the end date. This date can be any English textual format  
            // $date_to = strtotime($request->b_date2); // Convert date to a UNIX timestamp  
            
            // $dates = [];

            // // Loop from the start date to end date and output all dates inbetween  
            // for ($i=$date_from; $i<=$date_to; $i+=86400) {  
            //     array_push($dates,date("Y-m-d", $i));  
            // }
            
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 2])->whereBetween('created_at',[$request->b_date1,$request->b_date2])->groupBy('date')->get();
            
            $dateLabel = [];
            $booking = [];

            foreach($bookings as $b)
            {
                array_push($booking,$b->count);
                array_push($dateLabel,$b->date);
            }                                   

            $response = [
                'msg' => 'Bookings Day-wise',
                'status' => 1,
                'bookings' => $booking,
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
}
