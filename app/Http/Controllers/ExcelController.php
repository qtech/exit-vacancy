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
                'Name' => $value->fname." ".$value->lname,
                'Email' => $value->email,
                'Number' => $value->customer->number,
                'Email Verified' => $value->is_email_verify == 1 ? 'YES' : 'NO',
                'Mobile Verified' => $value->is_mobile_verify == 1 ? 'YES' : 'NO',
                'Bookings' => $value->bookings,
                'User Status' => $value->user_status == 1 ? 'Active' : 'In-Active'
            ];

            array_push($users,$tmp);
        }

        Excel::create('AppUsers', function($excel) use($users){
            $excel->sheet('Sheet 1', function($sheet) use($users){
                $sheet->setStyle(array(
                    'font' => array(
                        'name'      =>  'Barlow',
                        'size'      =>  12,
                    )
                ));
                
                $sheet->cells('A1:G1', function ($cells) {
                    $cells->setBackground('#00857B');
                });

                $sheet->getDefaultStyle()->getAlignment()
                ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $sheet->fromArray($users);
            });
        })->download('xls');
    }   
}
