<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Hoteldata;
use Validator;

class nearbyhotelController extends Controller
{
    public function nearbyhotel_directions(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'latitude' => 'required',
                'longitude' => 'required'
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
                $nearby = DB::select( DB::raw("SELECT * ,((((acos(sin((".$request->latitude."*pi()/180)) * sin((`latitude`*pi()/180))+cos((".$request->latitude."*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((".$request->longitude."- `longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344)) as `distance` FROM `hotel_data` HAVING `distance`<= 100 ORDER BY `distance` ASC") );

                if(count($nearby) == 0)
                {
                    $response = [
                        'msg' => 'Sorry! No hotels available near your locations',
                        'status' => 0
                    ];
                }
                else
                {
                    if($request->direction == "")
                    {
                        $data = [];

                        foreach($nearby as $value)
                        {
                            $temp = [
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
                                'longitude' => $value->longitude,
                                'distance' => $value->distance
                            ];
                            array_push($data,$temp);
                        }

                        $response = [
                            'msg' => count($nearby).' hotels available nearby your current location',
                            'status' => 1,
                            'data' => $data
                        ];
                    }
                    else
                    {
                        $north = [];
                        $east = [];
                        $south = [];
                        $west = [];

                        foreach($nearby as $value)
                        {
                            $bearing = (rad2deg(atan2(sin(deg2rad($value->longitude) - deg2rad($request->longitude)) * cos(deg2rad($value->latitude)), cos(deg2rad($request->latitude)) * sin(deg2rad($value->latitude)) - sin(deg2rad($request->latitude)) * cos(deg2rad($value->latitude)) * cos(deg2rad($value->longitude) - deg2rad($request->longitude)))) + 360) % 360;

                            $tmp = round($bearing / 22.5);

                            if($tmp == 1 || $tmp == 15 || $tmp == 16 || $tmp == 0)
                            {
                                $direction = "North";
                            }
                            if($tmp == 3 || $tmp == 4 || $tmp == 5) 
                            {
                                $direction = "East";
                            }
                            if($tmp == 7 || $tmp == 8 || $tmp == 9) 
                            {
                                $direction = "South";
                            }
                            if($tmp == 11 || $tmp == 12 || $tmp == 13) 
                            {
                                $direction = "West";
                            }
                            if($tmp == 2)
                            {
                                $direction = "North-East";
                            }
                            if($tmp == 6)
                            {
                                $direction = "South-East";
                            }
                            if($tmp == 10)
                            {
                                $direction = "South-West";
                            }
                            if($tmp == 14)
                            {
                                $direction = "North-West";
                            }

                            $data = [
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
                                'longitude' => $value->longitude,
                                'distance' => $value->distance,
                                'direction' => $direction
                            ];

                            if($data['direction'] == "North" || $data['direction'] == "North-East" || $data['direction'] == "North-West")
                            {
                                array_push($north,$data);
                            }
                            if($data['direction'] == "East" || $data['direction'] == "North-East" || $data['direction'] == "South-East")
                            {
                                array_push($east,$data);
                            }
                            if($data['direction'] == "South" || $data['direction'] == "South-East" || $data['direction'] == "South-West")
                            {
                                array_push($south,$data);
                            }
                            if($data['direction'] == "West" || $data['direction'] == "South-West" || $data['direction'] == "North-West")
                            {
                                array_push($west,$data);
                            }
                        }

                        if($request->direction == 1)
                        {
                            $response = [
                                'msg' => count($north).' hotels available in selected direction',
                                'status' => 1,
                                'data' => $north
                            ];
                        }
                        if($request->direction == 2)
                        {
                            $response = [
                                'msg' => count($east).' hotels available in selected direction',
                                'status' => 1,
                                'data' => $east
                            ];
                        }
                        if($request->direction == 3)
                        {
                            $response = [
                                'msg' => count($south).' hotels available in selected direction',
                                'status' => 1,
                                'data' => $south
                            ];
                        }
                        if($request->direction == 4)
                        {
                            $response = [
                                'msg' => count($west).' hotels available in selected direction',
                                'status' => 1,
                                'data' => $west
                            ];
                        }
                    }
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
