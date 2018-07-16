<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Hoteldata;
use App\Ratereviews;
use Validator;

class RatereviewController extends Controller
{
    public function store_ratings(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'user_id' => 'required',
                'hotel_id' => 'required',
                'ratings' => 'required',
                'review_comment' => 'required'
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
                $rate = Ratereviews::create($request->all());

                $response = [
                    'msg' => 'Success! Thankyou for the ratings',
                    'status' => 1
                ];
            }
        }
        catch(\Exception $e)
        {
            $response = [
                'msg' => $e->getMessage(),
                'status' => 0
            ];
        }
        return response()->json($response);
    }

    public function show_ratings(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'hotel_id' => 'required'
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
                $review = Ratereviews::with('user','hotel')->where(['hotel_id' => $request->hotel_id])->get();
                
                if(count($review) == 0)
                {
                    $response = [
                        'msg' => 'Sorry! No ratings available for this Hotel',
                        'status' => 0
                    ];
                }
                else
                {
                    $data = [];
                    $rate = 0;
                    $r5 = 0;
                    $r4 = 0;
                    $r3 = 0;
                    $r2 = 0;
                    $r1 = 0;

                    foreach($review as $tmp)
                    {
                        $collect = [
                            'review_id' => $tmp->review_id,
                            'user' => $tmp->user->fname." ".$tmp->user->lname,
                            'hotel' => $tmp->hotel->hotel_name,
                            'ratings' => $tmp->ratings,
                            'review' => $tmp->review_comment,
                            'hotel_image' => ($tmp->hotel->image != NULL) ? url('/')."/".$tmp->hotel->image : "",
                        ];

                        array_push($data,$collect);
                        
                        if($tmp->ratings == 5)
                        {
                            $r5 += $tmp->ratings;
                        }
                        if($tmp->ratings == 4)
                        {
                            $r4 += $tmp->ratings;
                        }
                        if($tmp->ratings == 3)
                        {
                            $r3 += $tmp->ratings;
                        }
                        if($tmp->ratings == 2)
                        {
                            $r2 += $tmp->ratings;
                        }
                        if($tmp->ratings == 1)
                        {
                            $r1 += $tmp->ratings;
                        }
                    }

                    $count = count($review);
                    if($count > 0)
                    {
                        $ratings = round(($r5 + $r4 + $r3 + $r2 + $r1)/$count);
                    }
                    else
                    {
                        $ratings = 0;
                    }

                    $response = [
                        'msg' => 'Ratings and Reviews for the Hotel',
                        'status' => 1,
                        'hotel_ratings' => $ratings,
                        'data' => $data
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
