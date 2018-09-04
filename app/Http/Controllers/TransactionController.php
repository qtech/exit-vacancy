<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Bookings;
use App\Hoteldata;
use DB;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function view($id = NULL)
    {
        try
        {
            if($id)
            {
                if($id == 1)
                {
                    $transactions = Bookings::with('user','hotel')->where(['payment_status' => 1])->whereDay('created_at',today()->format('d'))->get();
                }   
                if($id == 2)
                {
                    $present = Carbon::now();
                    $past = Carbon::now()->subDays(6)->toDateString();
                    
                    $transactions = Bookings::with('user','hotel')->where(['payment_status' => 1])->whereBetween('created_at',[$past,$present])->get();
                }
                if($id == 3)
                {
                    $transactions = Bookings::with('user','hotel')->where(['payment_status' => 1])->whereMonth('created_at',today()->format('m'))->get();
                }
            }
            else
            {
                $transactions = Bookings::with('user','hotel')->where(['payment_status' => 1])->get();
            }

            $data = [
                'id' => $id,
                'transactions' => $transactions
            ];
            
            return view('transactions.main')->with($data);
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }

    public function all_transaction()
    {
        try
        {
            $present = Carbon::now();
            $past = Carbon::now()->subMonth()->toDateString();

            $transactions = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['payment_status' => 1])->whereBetween('created_at',[$past,$present])->groupBy('date')->get();
            
            $dateLabel = [];
            $transaction = [];

            foreach($transactions as $t)
            {
                array_push($transaction,$t->count);
                array_push($dateLabel,$t->date);
            }                                   

            $response = [
                'msg' => 'Transactions Day-wise',
                'status' => 1,
                'transactions' => $transaction,
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

    public function today_transaction()
    {
        try
        {
            $transactions = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['payment_status' => 1])->whereDay('created_at',today()->format('d'))->groupBy('date')->get();
            
            $dateLabel = [];
            $transaction = [];

            foreach($transactions as $value)
            {
                array_push($transaction,$value->count);
                array_push($dateLabel,$value->date);
            }

            $response = [
                'msg' => 'Today\'s Transactions',
                'status' => 1,
                'transactions' => $transaction,
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

    public function week_transaction()
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

            $transactions = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['payment_status' => 1])->whereBetween('created_at',[$past,$present])->groupBy('date')->get();
            
            $dateLabel = [];
            $transaction = [];

            foreach($transactions as $t)
            {
                array_push($transaction,$t->count);
                array_push($dateLabel,$t->date);
            }                                   

            $response = [
                'msg' => 'Weekly Transactions',
                'status' => 1,
                'transactions' => $transaction,
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

    public function month_transaction()
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

            $transactions = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['payment_status' => 1])->whereMonth('created_at',today()->format('m'))->groupBy('date')->get();
            
            $dateLabel = [];
            $transaction = [];
            
            foreach($transactions as $t)
            {    
                array_push($transaction,$t->count);
                array_push($dateLabel,$t->date);                                
            }

            $response = [
                'msg' => 'Monthly Transactions',
                'status' => 1,
                'transactions' => $transaction,
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

    public function dates_transaction(Request $request)
    {
        try
        {
            // $date_from = strtotime($request->t_date1); // Convert date to a UNIX timestamp  
  
            // // Specify the end date. This date can be any English textual format  
            // $date_to = strtotime($request->t_date2); // Convert date to a UNIX timestamp  
            
            // $dates = [];

            // // Loop from the start date to end date and output all dates inbetween  
            // for ($i=$date_from; $i<=$date_to; $i+=86400) {  
            //     array_push($dates,date("Y-m-d", $i));  
            // }

            $transactions = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->where(['payment_status' => 1])->whereBetween('created_at',[$request->t_date1,$request->t_date2])->groupBy('date')->get();
            
            $dateLabel = [];
            $transaction = [];

            foreach($transactions as $t)
            {
                array_push($transaction,$t->count);
                array_push($dateLabel,$t->date);
            }                                   

            $response = [
                'msg' => 'Transactions on selected dates',
                'status' => 1,
                'transactions' => $transaction,
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
