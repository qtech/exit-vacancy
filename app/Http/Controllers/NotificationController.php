<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications;
use App\User;
use Validator;

class NotificationController extends Controller
{
    public function view()
    {
        $notification = Notifications::all();
        return view('notifications.main')->with('notification', $notification);
    }
    public function add()
    {
        return view('notifications.add');
    }

    public function store(Request $request)
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
                $notification->save();

                $count = User::increment('notification_count',1);
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

    public function delete($id)
    {
        $delete = Notifications::find($id)->delete();
        return redirect()->route('notifications')->with('success', 'Notification deleted successfully');
    }
}
