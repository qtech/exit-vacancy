<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;


class DashboardController extends Controller
{
    public function view()
    {
        // $user = User::where(['role' => 2])->groupBy('created_at',format('d-m-y'))->get();
        // $user= User::where(['role' => 2])->groupBy(function($val) {
        //     return $val->Carbon::parse('created_at')->format('m');
        // })->get();
        $user = DB::table('users')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                ->groupBy('date')
                ->get();
            
        return view('dashboard.main')->with('user', $user);
    }
}
