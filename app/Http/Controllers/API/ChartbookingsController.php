<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bookings;
use DB;

class ChartbookingsController extends Controller
{
    public function all_completed()
    {
        try
        {
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1, 'is_visited' => 1])->groupBy('date')->get();
            
            $dateLabel = ["2018-07-23","2018-07-26"];
            $booking = [2,6];

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
            $today = today();
            $week = $today->modify('-7 days');

            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1, 'is_visited' => 1])->whereBetween('created_at',[$week,today()])->groupBy('date')->get();
            
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

    public function month_completed()
    {
        try
        {
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1, 'is_visited' => 1])->whereMonth('created_at',today()->format('m'))->groupBy('date')->get();
            
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

    public function dates_completed(Request $request)
    {
        try
        {
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1, 'is_visited' => 1])->whereBetween('created_at',[$request->b_date1,$request->b_date2])->groupBy('date')->get();
            
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

    public function all_pending()
    {
        try
        {
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1, 'is_visited' => 0])->groupBy('date')->get();
            
            $dateLabel = ["2018-07-23","2018-07-26"];
            $booking = [2,6];

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
            $today = today();
            $week = $today->modify('-7 days');

            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1, 'is_visited' => 0])->whereBetween('created_at',[$week,today()])->groupBy('date')->get();
            
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

    public function month_pending()
    {
        try
        {
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1, 'is_visited' => 0])->whereMonth('created_at',today()->format('m'))->groupBy('date')->get();
            
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

    public function dates_pending(Request $request)
    {
        try
        {
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 1, 'is_visited' => 0])->whereBetween('created_at',[$request->b_date1,$request->b_date2])->groupBy('date')->get();
            
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

    public function all_cancelled()
    {
        try
        {
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 2])->groupBy('date')->get();
            
            $dateLabel = ["2018-07-23","2018-07-26"];
            $booking = [2,6];

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

    public function today_cancelled()
    {
        try
        {
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 2])->whereDay('created_at',today()->format('d'))->groupBy('date')->get();
            
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

    public function week_cancelled()
    {
        try
        {
            $today = today();
            $week = $today->modify('-7 days');

            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 2])->whereBetween('created_at',[$week,today()])->groupBy('date')->get();
            
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

    public function month_cancelled()
    {
        try
        {
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 2])->whereMonth('created_at',today()->format('m'))->groupBy('date')->get();
            
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

    public function dates_cancelled(Request $request)
    {
        try
        {
            $bookings = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['status' => 2])->whereBetween('created_at',[$request->b_date1,$request->b_date2])->groupBy('date')->get();
            
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
}
