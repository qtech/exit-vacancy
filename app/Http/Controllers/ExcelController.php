<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\User;

class ExcelController extends Controller
{
    public function getappusers()
    {
        $user = User::with('customer')->where(['role' => 2])->get();
        $users = [];
        foreach($user as $value)
        {
            $tmp = [
                'name' => $value->fname." ".$value->lname,
                'email' => $value->email,
                'number' => $value->customer->number,
                'email_verified' => $value->is_email_verify == 1 ? 'YES' : 'NO',
                'mobile_verified' => $value->is_mobile_verify == 1 ? 'YES' : 'NO',
                'bookings' => $value->bookings,
                'user_status' => $value->user_status == 1 ? 'Active' : 'In-Active'
            ];

            array_push($users,$tmp);
        }

        Excel::create('AppUsers', function($excel) use($users){
            $excel->sheet('Sheet 1', function($sheet) use($users){
                $sheet->row('A1:G1', function($row) {
                    $row->setBackground('#00857B');
                });
                $sheet->fromArray($users);
            });
        })->download('xls');
    }   
}
