<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function view()
    {
        try
        {
            return view('transactions.main');
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }

    public function transaction_chart()
    {
        try
        {
            // if($request->id)
            // {
                // $transactions = DB::table('bookings')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'), DB::raw('status'), DB::raw('is_visited'))->where(['user_id' => $request->id])->groupBy('date')->get();
            
                $dateLabel = ["2018-07-23","2018-07-26","2018-07-27","2018-07-29","2018-07-30","2018-08-01","2018-08-02","2018-08-04","2018-08-07",];
                $transaction = ['24','29','50','81','34','17','43','51','30'];

                // foreach($transactions as $value)
                // {
                //     if($value->status == 1)
                //     {
                //         if($value->is_visited == 1)
                //         {
                //             array_push($dateLabel,$value->date);
                //             array_push($completed,$value->count);
                //             array_push($pending,0);
                //             array_push($cancelled,0);
                //         }
                //         else
                //         {
                //             array_push($dateLabel,$value->date);
                //             array_push($pending,$value->count);
                //             array_push($completed,0);
                //             array_push($cancelled,0);
                //         }
                //     }
                //     else
                //     {
                //         array_push($dateLabel,$value->date);
                //         array_push($cancelled,$value->count);
                //         array_push($completed,0);
                //         array_push($pending,0);
                //     }
                // }

                $response = [
                    'msg' => 'Transactions',
                    'status' => 1,
                    'transactions' => $transaction,
                    'dateLabel' => $dateLabel
                ];
            // }
            // else
            // {
            //     $response = [
            //         'msg' => 'Invalid Parameters',
            //         'status' => 0
            //     ];
            // }
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
