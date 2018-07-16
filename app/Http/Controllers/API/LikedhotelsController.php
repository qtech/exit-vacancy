<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Likedhotels;
use Validator;

class LikedhotelsController extends Controller
{
    public function like_hotel(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'hotel_id' => 'required',
                'user_id' => 'required'
            ]);

            if($validator->fails())
            {
                $response = [
                    'msg' => 'Oops! Some field is missing',
                    'status' => 0
                ];
            }
            else
            {
                $check = Likedhotels::where(['user_id' => $request->user_id,'hotel_id' => $request->hotel_id,'status' => 1])->get();

                if(count($check) == 0)
                {
                    $like = new Likedhotels;
                    $like->hotel_id = $request->hotel_id;
                    $like->user_id = $request->user_id;
                    $like->status = 1;
                    $like->save();

                    $response = [
                        'msg' => 'You liked this Hotel',
                        'status' => 1
                    ];
                }
                else
                {
                    $response = [
                        'msg' => 'You have already liked this hotel',
                        'status' => 0
                    ];
                }
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

    public function dislike_hotel(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'hotel_id' => 'required',
                'user_id' => 'required'
            ]);

            if($validator->fails())
            {
                $response = [
                    'msg' => 'Oops! Some field is missing',
                    'status' => 0
                ];
            }
            else
            {
                $dislike = Likedhotels::where(['user_id' => $request->user_id,'hotel_id' => $request->hotel_id,'status' => 1])->delete();
                
                $response = [
                    'msg' => 'You disliked this Hotel',
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

    public function show_liked_hotels(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'user_id' => 'required'
            ]);

            if($validator->fails())
            {
                $response = [
                    'msg' => 'Oops! Some field is missing',
                    'status' => 0
                ];
            }
            else
            {
                $likedhotels = Likedhotels::with('hotels')->where(['user_id' => $request->user_id,'status' => 1])->get();

                if(count($likedhotels) > 0)
                {
                    $data = [];

                    foreach($likedhotels as $value)
                    {
                        $tmp = [
                            'hotel_name' => $value->hotels->hotel_name,
                            'hotel_image' => ($value->hotels->image != NULL) ? url('/')."/".$value->hotels->image : "",
                            'hotel_stars' => $value->hotels->stars,
                            'hotel_price' => $value->hotels->price
                        ];

                        array_push($data,$tmp);
                    }

                    $response = [
                        'msg' => 'List of liked hotels',
                        'status' => 1,
                        'data' => $data
                    ];
                }
                else
                {
                    $response = [
                        'msg' => 'No liked hotels',
                        'status' => 0
                    ];
                }
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
}
