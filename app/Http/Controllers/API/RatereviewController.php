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
}
