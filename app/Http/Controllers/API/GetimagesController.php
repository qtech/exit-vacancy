<?php

namespace App\Http\Controllers\API;

use App\Jobs\Getimages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hoteldata;

class GetimagesController extends Controller
{
    public function getImages(Request $request)
    {
        try
        {
            $hotels = Hoteldata::where(['image' => NULL])->get();
            
            foreach($hotels as $value)
            {
                $data = [
                    'name' => $value->hotel_name,
                    'id' => $value->hotel_data_id
                ];

                Getimages::dispatch($data);
            }

            $response = [
                'msg' => 'Success',
                'status' => 1
            ];
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
