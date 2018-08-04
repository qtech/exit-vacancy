<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\massmails;
use App\Notifications;
use App\User;
use Validator;

class EmailController extends Controller
{
    public function user_view()
    {
        $mail = Notifications::where(['status' => 1, 'type' => 2])->get();
        return view('sendemails.main')->with('mail', $mail);
    }
    public function user_add($id = NULL)
    {
        if($id)
        {
            if($id == 1)
            {
                $users = User::with('customer')->where(['role' => 2,'bookings' => 0])->get();
                return view('sendemails.add')->with('users', $users);
            }
            if($id == 2)
            {
                $users = User::with('customer')->with(['bookings' => function($query){
                    return $query->whereMonth('created_at', today()->format('m'))->groupBy('user_id');
                }])->where(['role' => 2])->get();                
                
                return view('sendemails.add')->with('users', $users);
            }
            if($id == 3)
            {
                $users = User::with('customer')->where(['role' => 2])->where('bookings','>', 5)->get();
                return view('sendemails.add')->with('users', $users);
            }
            if($id == 4)
            {
                $users = User::with('customer')->where(['role' => 2])->whereMonth('created_at', today()->format('m'))->get();
                return view('sendemails.add')->with('users', $users);
            }
        }
        else
        {
            $users = User::with('customer')->where(['role' => 2])->get();
            return view('sendemails.add')->with('users', $users);
        }
    }

    public function user_send(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'subject' => 'required',
                'message' => 'required',
                'mails' => 'required'
            ]);

            if($validator->fails())
            {
                $response = [
                    'msg' => 'Oops! Something is missing',
                    'status' => 0
                ];
            }
            else
            {
                $notification = new Notifications;
                $notification->title = $request->subject;
                $notification->message = $request->message;
                $notification->type = 2;
                $notification->status = 1;
                $notification->save();

                foreach($request->mails as $user)
                {
                    $mail = User::find($user);
                    $data = [
                        'fname' => $mail->fname,
                        'lname' => $mail->lname,
                        'message' => $request->message,
                        'subject' => $request->subject
                    ];
                    \Mail::to($mail->email)->send(new massmails($data));
                }

                $response = [
                    'msg' => 'Email Sent',
                    'status' => 1
                ];
            }
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

    public function user_delete($id)
    {
        $delete = Notifications::find($id)->delete();
        return redirect()->route('mails')->with('success', 'Sent Email deleted successfully');
    }

    public function hotel_view()
    {
        $mail = Notifications::where(['status' => 2, 'type' => 2])->get();
        return view('sendemails_hotel.main')->with('mail', $mail);
    }
    public function hotel_add()
    {
        return view('sendemails_hotel.add');
    }

    public function hotel_send(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'subject' => 'required',
                'message' => 'required'
            ]);

            if($validator->fails())
            {
                $response = [
                    'msg' => 'Oops! Something is missing',
                    'status' => 0
                ];
            }
            else
            {
                $notification = new Notifications;
                $notification->title = $request->subject;
                $notification->message = $request->message;
                $notification->type = 2;
                $notification->status = 2;
                $notification->save();

                $users = User::where(['role' => 3])->get();
                
                if(count($users) > 0)
                {
                    foreach($users as $user)
                    {
                        $mail = User::find($user->user_id);
                        $data = [
                            'fname' => $mail->fname,
                            'lname' => $mail->lname,
                            'message' => $request->message,
                            'subject' => $request->subject
                        ];
                        \Mail::to($mail->email)->send(new massmails($data));
                    }
                }

                $response = [
                    'msg' => 'Email sent',
                    'status' => 1
                ];
            }
        }
        catch(\Exception $e)
        {
            $response = [
                'msg' => $e->getMessage()."".$e->getLine(),
                'status' => 0
            ];
        }
        return response()->json($response);
    }

    public function hotel_delete($id)
    {
        $delete = Notifications::find($id)->delete();
        return redirect()->route('h.mail')->with('success', 'Sent Email deleted successfully');
    }
}
