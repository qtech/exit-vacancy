<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\User;
use App\Bookings;

class ExcelController extends Controller
{
    public function gethotelusers()
    {
        $hotel = User::with('hotel')->where(['role' => 3])->get();

        if(count($hotel) > 0)
        {
            $hotels = [];
            foreach($hotel as $value)
            {
                $tmp = [
                    'Name' => $value->fname." ".$value->lname,
                    'Email' => $value->email,
                    'Number' => $value->hotel->number,
                    'Email Verified' => $value->is_email_verify == 1 ? 'YES' : 'NO',
                    'Mobile Verified' => $value->is_mobile_verify == 1 ? 'YES' : 'NO',
                    'Bookings' => $value->bookings == '0' ? '0' : $value->bookings,
                    'User Status' => $value->user_status == 1 ? 'Active' : 'In-Active'
                ];
    
                array_push($hotels,$tmp);
            }
    
            Excel::create('HotelUsers', function($excel) use($hotels){
                $excel->sheet('Sheet 1', function($sheet) use($hotels){
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
    
                    $sheet->fromArray($hotels);
                });
            })->download('xls');
        }
        else
        {
            return redirect()->route('hotelusers')->with('error', 'No records found for Excel Sheet');
        }
    }

    public function getappusers()
    {
        $user = User::with('customer')->where(['role' => 2])->get();

        if(count($user) > 0)
        {
            $users = [];
            foreach($user as $value)
            {
                $tmp = [
                    'Name' => $value->fname." ".$value->lname,
                    'Email' => $value->email,
                    'Number' => $value->customer->number,
                    'Email Verified' => $value->is_email_verify == 1 ? 'YES' : 'NO',
                    'Mobile Verified' => $value->is_mobile_verify == 1 ? 'YES' : 'NO',
                    'Bookings' => $value->bookings == '0' ? '0' : $value->bookings,
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
        else
        {
            return redirect()->route('appusers','1')->with('error', 'No records found for Excel Sheet');
        }
    }
    
    public function appusers_nobookings()
    {
        $user = User::with('customer','userbookings')->where(['role' => 2,'bookings' => 0])->get();

        if(count($user) > 0)
        {
            $users = [];
            foreach($user as $value)
            {
                $tmp = [
                    'Name' => $value->fname." ".$value->lname,
                    'Email' => $value->email,
                    'Number' => $value->customer->number,
                    'Email Verified' => $value->is_email_verify == 1 ? 'YES' : 'NO',
                    'Mobile Verified' => $value->is_mobile_verify == 1 ? 'YES' : 'NO',
                    'Bookings' => $value->bookings == '0' ? '0' : $value->bookings,
                    'User Status' => $value->user_status == 1 ? 'Active' : 'In-Active'
                ];
    
                array_push($users,$tmp);
            }
    
            Excel::create('Users_no_bookings', function($excel) use($users){
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
        else
        {
            return redirect()->route('appusers','1')->with('error', 'No records found for Excel Sheet');
        }
    }

    public function appusers_bookings_this_month()
    {
        $collect = User::with('customer')->with(['userbookings' => function($query){
            return $query->whereMonth('created_at', today()->format('m'))->groupBy('user_id');
        }])->where(['role' => 2])->get();

        $user = [];
        foreach($collect as $tmp)
        {
            if(count($tmp->userbookings) > 0)
            {
                array_push($user,$tmp);
            }
        }

        if(count($user) > 0)
        {
            $users = [];
            foreach($user as $value)
            {
                $tmp = [
                    'Name' => $value->fname." ".$value->lname,
                    'Email' => $value->email,
                    'Number' => $value->customer->number,
                    'Email Verified' => $value->is_email_verify == 1 ? 'YES' : 'NO',
                    'Mobile Verified' => $value->is_mobile_verify == 1 ? 'YES' : 'NO',
                    'Bookings' => $value->bookings == '0' ? '0' : $value->bookings,
                    'User Status' => $value->user_status == 1 ? 'Active' : 'In-Active'
                ];
    
                array_push($users,$tmp);
            }
    
            Excel::create('Userbookings_this_month', function($excel) use($users){
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
        else
        {
            return redirect()->route('appusers','2')->with('error', 'No records found for Excel Sheet');
        }
    }

    public function appusers_bookingsfiveplus()
    {
        $user = User::with('customer','userbookings')->where(['role' => 2])->where('bookings','>', 5)->get();

        if(count($user) > 0)
        {
            $users = [];
            foreach($user as $value)
            {
                $tmp = [
                    'Name' => $value->fname." ".$value->lname,
                    'Email' => $value->email,
                    'Number' => $value->customer->number,
                    'Email Verified' => $value->is_email_verify == 1 ? 'YES' : 'NO',
                    'Mobile Verified' => $value->is_mobile_verify == 1 ? 'YES' : 'NO',
                    'Bookings' => $value->bookings == '0' ? '0' : $value->bookings,
                    'User Status' => $value->user_status == 1 ? 'Active' : 'In-Active'
                ];
    
                array_push($users,$tmp);
            }
    
            Excel::create('Userbookings_fiveplus', function($excel) use($users){
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
        else
        {
            return redirect()->route('appusers','3')->with('error', 'No records found for Excel Sheet');
        }
    }

    public function appusers_registerthismonth()
    {
        $user = User::with('customer','userbookings')->where(['role' => 2])->whereMonth('created_at', today()->format('m'))->get();

        if(count($user) > 0)
        {
            $users = [];
            foreach($user as $value)
            {
                $tmp = [
                    'Name' => $value->fname." ".$value->lname,
                    'Email' => $value->email,
                    'Number' => $value->customer->number,
                    'Email Verified' => $value->is_email_verify == 1 ? 'YES' : 'NO',
                    'Mobile Verified' => $value->is_mobile_verify == 1 ? 'YES' : 'NO',
                    'Bookings' => $value->bookings == '0' ? '0' : $value->bookings,
                    'User Status' => $value->user_status == 1 ? 'Active' : 'In-Active'
                ];
    
                array_push($users,$tmp);
            }
    
            Excel::create('Userregister_month', function($excel) use($users){
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
        else
        {
            return redirect()->route('appusers','4')->with('error', 'No records found for Excel Sheet');
        }
    }

    public function completedbookings()
    {
        $booking = Bookings::with('user','hotel')->where(['status' => 1, 'is_visited' => 1])->get();

        if(count($booking) > 0)
        {
            $bookings = [];
            foreach($booking as $value)
            {
                $tmp = [
                    'User Name' => $value->user->fname." ".$value->user->lname,
                    'Hotel Name' => $value->hotel->hotel_name,
                    'Room Type' => $value->roomtype,
                    'Price' => '$'.$value->roomprice,
                    'Booking Time' => $value->status_time,
                    'Arrived Time' => $value->visited_time,
                ];
    
                array_push($bookings,$tmp);
            }
    
            Excel::create('Completed_Bookings', function($excel) use($bookings){
                $excel->sheet('Sheet 1', function($sheet) use($bookings){
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
    
                    $sheet->fromArray($bookings);
                });
            })->download('xls');
        }
        else
        {
            return redirect()->route('completed.bookings')->with('error', 'No records found for Excel Sheet');
        }
    }

    public function completed_todaybookings()
    {
        $booking = Bookings::with('user','hotel')->where(['status' => 1, 'is_visited' => 1])->whereDay('created_at',today()->format('d'))->get();

        if(count($booking) > 0)
        {
            $bookings = [];
            foreach($booking as $value)
            {
                $tmp = [
                    'User Name' => $value->user->fname." ".$value->user->lname,
                    'Hotel Name' => $value->hotel->hotel_name,
                    'Room Type' => $value->roomtype,
                    'Price' => '$'.$value->roomprice,
                    'Booking Time' => $value->status_time,
                    'Arrived Time' => $value->visited_time,
                ];
    
                array_push($bookings,$tmp);
            }
    
            Excel::create('Completed_TodayBookings', function($excel) use($bookings){
                $excel->sheet('Sheet 1', function($sheet) use($bookings){
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
    
                    $sheet->fromArray($bookings);
                });
            })->download('xls');
        }
        else
        {
            return redirect()->route('completed.bookings','1')->with('error', 'No records found for Excel Sheet');
        }
    }

    public function completed_weekbookings()
    {
        $today = today();
        $week = $today->modify('-7 days');
        
        $booking = Bookings::with('user','hotel')->where(['status' => 1, 'is_visited' => 1])->whereBetween('created_at',[$week,today()])->get();

        if(count($booking) > 0)
        {
            $bookings = [];
            foreach($booking as $value)
            {
                $tmp = [
                    'User Name' => $value->user->fname." ".$value->user->lname,
                    'Hotel Name' => $value->hotel->hotel_name,
                    'Room Type' => $value->roomtype,
                    'Price' => '$'.$value->roomprice,
                    'Booking Time' => $value->status_time,
                    'Arrived Time' => $value->visited_time,
                ];
    
                array_push($bookings,$tmp);
            }
    
            Excel::create('Completed_WeekBookings', function($excel) use($bookings){
                $excel->sheet('Sheet 1', function($sheet) use($bookings){
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
    
                    $sheet->fromArray($bookings);
                });
            })->download('xls');
        }
        else
        {
            return redirect()->route('completed.bookings','2')->with('error', 'No records found for Excel Sheet');
        }
    }

    public function completed_monthbookings()
    {
        $booking = Bookings::with('user','hotel')->where(['status' => 1, 'is_visited' => 1])->whereMonth('created_at',today()->format('m'))->get();

        if(count($booking) > 0)
        {
            $bookings = [];
            foreach($booking as $value)
            {
                $tmp = [
                    'User Name' => $value->user->fname." ".$value->user->lname,
                    'Hotel Name' => $value->hotel->hotel_name,
                    'Room Type' => $value->roomtype,
                    'Price' => '$'.$value->roomprice,
                    'Booking Time' => $value->status_time,
                    'Arrived Time' => $value->visited_time,
                ];
    
                array_push($bookings,$tmp);
            }
    
            Excel::create('Completed_MonthBookings', function($excel) use($bookings){
                $excel->sheet('Sheet 1', function($sheet) use($bookings){
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
    
                    $sheet->fromArray($bookings);
                });
            })->download('xls');
        }
        else
        {
            return redirect()->route('completed.bookings','3')->with('error', 'No records found for Excel Sheet');
        }
    }

    public function pendingbookings()
    {
        $booking = Bookings::with('user','hotel')->where(['status' => 1, 'is_visited' => 0])->get();

        if(count($booking) > 0)
        {
            $bookings = [];
            foreach($booking as $value)
            {
                $tmp = [
                    'User Name' => $value->user->fname." ".$value->user->lname,
                    'Hotel Name' => $value->hotel->hotel_name,
                    'Room Type' => $value->roomtype,
                    'Price' => '$'.$value->roomprice,
                    'Booking Time' => $value->status_time,
                    'Arrived Time' => $value->visited_time,
                ];
    
                array_push($bookings,$tmp);
            }
    
            Excel::create('Pending_Bookings', function($excel) use($bookings){
                $excel->sheet('Sheet 1', function($sheet) use($bookings){
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
    
                    $sheet->fromArray($bookings);
                });
            })->download('xls');
        }
        else
        {
            return redirect()->route('pending.bookings')->with('error', 'No records found for Excel Sheet');
        }
    }

    public function pending_todaybookings()
    {
        $booking = Bookings::with('user','hotel')->where(['status' => 1, 'is_visited' => 0])->whereDay('created_at',today()->format('d'))->get();

        if(count($booking) > 0)
        {
            $bookings = [];
            foreach($booking as $value)
            {
                $tmp = [
                    'User Name' => $value->user->fname." ".$value->user->lname,
                    'Hotel Name' => $value->hotel->hotel_name,
                    'Room Type' => $value->roomtype,
                    'Price' => '$'.$value->roomprice,
                    'Booking Time' => $value->status_time,
                    'Arrived Time' => $value->visited_time,
                ];
    
                array_push($bookings,$tmp);
            }
    
            Excel::create('Pending_TodayBookings', function($excel) use($bookings){
                $excel->sheet('Sheet 1', function($sheet) use($bookings){
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
    
                    $sheet->fromArray($bookings);
                });
            })->download('xls');
        }
        else
        {
            return redirect()->route('pending.bookings','1')->with('error', 'No records found for Excel Sheet');
        }
    }

    public function pending_weekbookings()
    {
        $today = today();
        $week = $today->modify('-7 days');
        
        $booking = Bookings::with('user','hotel')->where(['status' => 1, 'is_visited' => 0])->whereBetween('created_at',[$week,today()])->get();

        if(count($booking) > 0)
        {
            $bookings = [];
            foreach($booking as $value)
            {
                $tmp = [
                    'User Name' => $value->user->fname." ".$value->user->lname,
                    'Hotel Name' => $value->hotel->hotel_name,
                    'Room Type' => $value->roomtype,
                    'Price' => '$'.$value->roomprice,
                    'Booking Time' => $value->status_time,
                    'Arrived Time' => $value->visited_time,
                ];
    
                array_push($bookings,$tmp);
            }
    
            Excel::create('Pending_WeekBookings', function($excel) use($bookings){
                $excel->sheet('Sheet 1', function($sheet) use($bookings){
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
    
                    $sheet->fromArray($bookings);
                });
            })->download('xls');
        }
        else
        {
            return redirect()->route('pending.bookings','2')->with('error', 'No records found for Excel Sheet');
        }
    }

    public function pending_monthbookings()
    {
        $booking = Bookings::with('user','hotel')->where(['status' => 1, 'is_visited' => 0])->whereMonth('created_at',today()->format('m'))->get();

        if(count($booking) > 0)
        {
            $bookings = [];
            foreach($booking as $value)
            {
                $tmp = [
                    'User Name' => $value->user->fname." ".$value->user->lname,
                    'Hotel Name' => $value->hotel->hotel_name,
                    'Room Type' => $value->roomtype,
                    'Price' => '$'.$value->roomprice,
                    'Booking Time' => $value->status_time,
                    'Arrived Time' => $value->visited_time,
                ];
    
                array_push($bookings,$tmp);
            }
    
            Excel::create('Pending_MonthBookings', function($excel) use($bookings){
                $excel->sheet('Sheet 1', function($sheet) use($bookings){
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
    
                    $sheet->fromArray($bookings);
                });
            })->download('xls');
        }
        else
        {
            return redirect()->route('pending.bookings','3')->with('error', 'No records found for Excel Sheet');
        }
    }

    public function cancelbookings()
    {
        $booking = Bookings::with('user','hotel')->where(['status' => 2])->get();

        if(count($booking) > 0)
        {
            $bookings = [];
            foreach($booking as $value)
            {
                $tmp = [
                    'User Name' => $value->user->fname." ".$value->user->lname,
                    'Hotel Name' => $value->hotel->hotel_name,
                    'Room Type' => $value->roomtype,
                    'Price' => '$'.$value->roomprice,
                    'Booking Time' => $value->status_time,
                    'Arrived Time' => $value->visited_time,
                ];
    
                array_push($bookings,$tmp);
            }
    
            Excel::create('Cancelled_Bookings', function($excel) use($bookings){
                $excel->sheet('Sheet 1', function($sheet) use($bookings){
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
    
                    $sheet->fromArray($bookings);
                });
            })->download('xls');
        }
        else
        {
            return redirect()->route('cancelled.bookings')->with('error', 'No records found for Excel Sheet');
        }
    }

    public function cancel_todaybookings()
    {
        $booking = Bookings::with('user','hotel')->where(['status' => 2])->whereDay('created_at',today()->format('d'))->get();

        if(count($booking) > 0)
        {
            $bookings = [];
            foreach($booking as $value)
            {
                $tmp = [
                    'User Name' => $value->user->fname." ".$value->user->lname,
                    'Hotel Name' => $value->hotel->hotel_name,
                    'Room Type' => $value->roomtype,
                    'Price' => '$'.$value->roomprice,
                    'Booking Time' => $value->status_time,
                    'Arrived Time' => $value->visited_time,
                ];
    
                array_push($bookings,$tmp);
            }
    
            Excel::create('Cancelled_TodayBookings', function($excel) use($bookings){
                $excel->sheet('Sheet 1', function($sheet) use($bookings){
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
    
                    $sheet->fromArray($bookings);
                });
            })->download('xls');
        }
        else
        {
            return redirect()->route('cancelled.bookings','1')->with('error', 'No records found for Excel Sheet');
        }
    }

    public function cancel_weekbookings()
    {
        $today = today();
        $week = $today->modify('-7 days');
        
        $booking = Bookings::with('user','hotel')->where(['status' => 2])->whereBetween('created_at',[$week,today()])->get();

        if(count($booking) > 0)
        {
            $bookings = [];
            foreach($booking as $value)
            {
                $tmp = [
                    'User Name' => $value->user->fname." ".$value->user->lname,
                    'Hotel Name' => $value->hotel->hotel_name,
                    'Room Type' => $value->roomtype,
                    'Price' => '$'.$value->roomprice,
                    'Booking Time' => $value->status_time,
                    'Arrived Time' => $value->visited_time,
                ];
    
                array_push($bookings,$tmp);
            }
    
            Excel::create('Cancelled_WeekBookings', function($excel) use($bookings){
                $excel->sheet('Sheet 1', function($sheet) use($bookings){
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
    
                    $sheet->fromArray($bookings);
                });
            })->download('xls');
        }
        else
        {
            return redirect()->route('cancelled.bookings','2')->with('error', 'No records found for Excel Sheet');
        }
    }

    public function cancel_monthbookings()
    {
        $booking = Bookings::with('user','hotel')->where(['status' => 2])->whereMonth('created_at',today()->format('m'))->get();

        if(count($booking) > 0)
        {
            $bookings = [];
            foreach($booking as $value)
            {
                $tmp = [
                    'User Name' => $value->user->fname." ".$value->user->lname,
                    'Hotel Name' => $value->hotel->hotel_name,
                    'Room Type' => $value->roomtype,
                    'Price' => '$'.$value->roomprice,
                    'Booking Time' => $value->status_time,
                    'Arrived Time' => $value->visited_time,
                ];
    
                array_push($bookings,$tmp);
            }
    
            Excel::create('Cancelled_MonthBookings', function($excel) use($bookings){
                $excel->sheet('Sheet 1', function($sheet) use($bookings){
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
    
                    $sheet->fromArray($bookings);
                });
            })->download('xls');
        }
        else
        {
            return redirect()->route('cancelled.bookings','3')->with('error', 'No records found for Excel Sheet');
        }
    }
}
