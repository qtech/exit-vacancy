<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Hoteldata;

class nearbyhotelController extends Controller
{
    public function nearbyHotel(Request $request)
    {
        try
        {
            $nearby = DB::select( DB::raw("SELECT * ,((((acos(sin((".$request->latitude."*pi()/180)) * sin((`latitude`*pi()/180))+cos((".$request->latitude."*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((".$request->longitude."- `longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344)) as `distance` FROM `hotel_data` HAVING `distance`<= 10 ORDER BY `distance`") );

            $data = [];
            
            foreach($nearby as $value)
            {
                $tmp = [
                    'hotel_id' => $value->hotel_data_id,
                    'hotel_name' => $value->hotel_name,
                    'image' => ($value->image != NULL) ? url('/')."/".$value->image : "",
                    'price' => $value->price,
                    'country' => $value->country,
                    'stars' => $value->stars,
                    'city' => $value->city,
                    'address' => $value->address,
                    'location' => $value->location,
                    'url' => $value->url,
                    'latitude' => $value->latitude,
                    'longitude' => $value->longitude
                ];

                array_push($data, $tmp);
            }

            $response = [
                'msg' => 'There are '.count($nearby).' hotels available nearby your location',
                'status' => 1,
                'data' => $data
            ];
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

    public function search_hotels(Request $request)
    {
        try
        {
            $hotel = $request->string;
            $search = Hoteldata::where('hotel_name','LIKE','%'.$hotel.'%')->get();
            if(count($search) > 0)
            {
                if(count($search) == 1)
                {
                    $data = [
                        'hotel_id' => $search->hotel_data_id,
                        'hotel_name' => $search->hotel_name,
                        'image' => ($search->image != NULL) ? url('/')."/".$search->image : "",
                        'stars' => $search->stars,
                        'country' => $search->country,
                        'address' => $search->address,
                        'location' => $search->location,
                        'url' => $search->url,
                        'latitude' => $search->latitude,
                        'longitude' => $search->longitude
                    ];

                    $response = [
                        'msg' => count($search)." hotel availalbe",
                        'status' => 1,
                        'data' => $search
                    ];
                }
                else
                {   
                    $data = [];

                    foreach($search as $value)
                    {
                        $tmp = [
                            'hotel_id' => $value->hotel_data_id,
                            'hotel_name' => $value->hotel_name,
                            'image' => ($search->image != NULL) ? url('/')."/".$search->image : "",
                            'stars' => $value->stars,
                            'country' => $value->country,
                            'address' => $value->address,
                            'location' => $value->location,
                            'url' => $value->url,
                            'latitude' => $value->latitude,
                            'longitude' => $value->longitude
                        ];

                        array_push($data, $tmp);
                    }

                    $response = [
                        'msg' => count($search)." hotels available",
                        'status' => 1,
                        'data' => $data
                    ];
                }
            }
            else
            {
                $response = [
                    'msg' => 'Sorry! No hotel with such name found',
                    'status' => 0
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
