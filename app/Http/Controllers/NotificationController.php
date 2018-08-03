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
        $notification = Notifications::where(['status' => 1])->get();
        return view('notifications.main')->with('notification', $notification);
    }
    public function user_add()
    {
        return view('notifications.add');
    }

    public function user_send(Request $request)
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
                $notification->status = 1;
                $notification->save();

                $count = User::where(['role' => 2])->increment('notification_count',1);
                $users = User::where(['role' => 2])->get();
                
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

    public function user_delete($id)
    {
        $delete = Notifications::find($id)->delete();
        return redirect()->route('notifications')->with('success', 'Notification deleted successfully');
    }

    public function hotel_view()
    {
        $notification = Notifications::where(['status' => 2])->get();
        return view('notifications_hotel.main')->with('notification', $notification);
    }
    public function hotel_add()
    {
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
