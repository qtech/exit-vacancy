<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications;
use App\User;
use Validator;

class NotificationController extends Controller
{
    public function user_view()
    {
        $notification = Notifications::where(['status' => 1, 'type' => 1])->get();
        return view('notifications.main')->with('notification', $notification);
    }
    public function user_add($id = NULL)
    {
        if($id)
        {
            if($id == 1)
            {
                $users = User::with('customer')->where(['role' => 2,'bookings' => 0])->get();
            }
            if($id == 2)
            {
                $users = User::with('customer')->with(['bookings' => function($query){
                    return $query->whereMonth('created_at', today()->format('m'))->groupBy('user_id');
                }])->where(['role' => 2])->get();                
            }
            if($id == 3)
            {
                $users = User::with('customer')->where(['role' => 2])->where('bookings','>', 5)->get();
            }
            if($id == 4)
            {
                $users = User::with('customer')->where(['role' => 2])->whereMonth('created_at', today()->format('m'))->get();
            }
        }
        else
        {
            $users = User::with('customer')->where(['role' => 2])->get();
        }

        $data = [
            'id' => $id,
            'users' => $users
        ];
        return view('notifications.add')->with($data);
    }

    public function user_send(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'title' => 'required',
                'message' => 'required',
                'notifications' => 'required'
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
                $notification->title = $request->title;
                $notification->message = $request->message;
                $notification->type = 1;
                $notification->status = 1;
                $notification->save();

                foreach($request->notifications as $user)
                {
                    $count = User::find($user);
                    $count->notification_count = $count->notification_count + 1;
                    $count->save();
                    $result = Notifications::commonNotification($request->title,$request->message,$count->fcm_id,$count->notification_count);
                }

                $response = [
                    'msg' => 'New notification added',
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
        return redirect()->route('notifications')->with('success', 'Notification deleted successfully');
    }

    public function hotel_view()
    {
        $notification = Notifications::where(['status' => 2, 'type' => 1])->get();
        return view('notifications_hotel.main')->with('notification', $notification);
    }
    public function hotel_add()
    {
        $users = User::with('customer')->where(['role' => 3])->get();
        return view('notifications_hotel.add');
    }

    public function hotel_send(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'title' => 'required',
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
                $notification->title = $request->title;
                $notification->message = $request->message;
                $notification->type = 1;
                $notification->status = 2;
                $notification->save();

                $count = User::where(['role' => 3])->increment('notification_count',1);
                $users = User::where(['role' => 3])->get();
                
                if(count($users) > 0)
                {
                    foreach($users as $user)
                    {
                        $result = Notifications::commonNotification($request->title,$request->message,$user->fcm_id,$user->notification_count);
                    }
                }

                $response = [
                    'msg' => 'New notification added',
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
        return redirect()->route('h.notifications')->with('success', 'Notification deleted successfully');
    }
}
