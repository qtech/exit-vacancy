<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use App\User;
use App\Notifications;
use App\Hoteldata;
use App\Customer;
use App\Bookings;
use App\BookingReference;
use App\Googlemaps;

class nearbyhotelController extends Controller
{
    public function nearbyhotel_notifications(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'latitude' => 'required',
                'longitude' => 'required',
                'user_id' => 'required',
                'distance' => 'required',
                'direction' => 'required',
                // 'stars' => 'required',
                'roomtype' => 'required',
                // 'amenities' => 'nullable'
            ]);

            if($validator->fails())
            {
                $response = [
                    'msg' => $validator->errors()->all(),
                    'status' => 0
                ];
            }
            else
            {
                $check_payment = Bookings::where(['user_id' => $request->user_id, 'status' => 1, 'payment_status' => 0])->first();

                if($check_payment)
                {   
                    $response = [
                        'msg' => 'Pay now for previous bookings',
                        'status' => 0
                    ];
                }
                else
                {
                    $check_booking = Bookings::where(['user_id' => $request->user_id, 'status' => 1, 'is_visited' => 0])->first();

                    if($check_booking)
                    {
                        $response = [
                            'msg' => 'You already have a pending booking.',
                            'status' => 0
                        ];
                    }
                    else
                    {
                        $roomtype = $request->roomtype;
                        // $stars = $request->stars;
    
                        // if($request->amenities != NULL)
                        // {
                        //     $amenity = explode(",",$request->amenities);
                        //     $count = count($amenity);
                        //     $ame_nity = "";
                        //     for($i=0;$i<$count;$i++)
                        //     {   
                        //         $ame_nity .= 'FIND_IN_SET("'.$amenity[$i].'",`amenities`) OR ';
                        //     }
                        //     $ame_nity = rtrim($ame_nity,"OR ");
                            
                        //     $nearby = DB::select( DB::raw("SELECT * ,((((acos(sin((".$request->latitude."*pi()/180)) * sin((`latitude`*pi()/180))+cos((".$request->latitude."*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((".$request->longitude."- `longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344)) as `distance` FROM `hotel_data` WHERE `status` = 1 AND ".$roomtype." AND `stars` IN (".$stars.") AND ".$ame_nity." HAVING `distance` <= ".$request->distance." ORDER BY `distance` ASC") );
                        // }
                        
                        $nearby = DB::select( DB::raw("SELECT * ,((((acos(sin((".$request->latitude."*pi()/180)) * sin((`latitude`*pi()/180))+cos((".$request->latitude."*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((".$request->longitude."- `longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344)) as `distance` FROM `hotel_data` WHERE `status` = 1 AND $roomtype HAVING `distance`<= ".$request->distance." ORDER BY `distance` ASC") );
                        
                        
                        if(count($nearby) == 0)
                        {
                            $response = [
                                'msg' => 'Sorry! No Active Hotels available near your locations',
                                'status' => 0
                            ];
                        }
                        else
                        {
                            if($request->direction == 0)
                            {
                                $data = [];
        
                                foreach($nearby as $value)
                                {
                                    if($request->roomtype == "king_room > 0")
                                    {
                                        if($value->king_room > 0)
                                        {
                                            $lat1 = $request->latitude;
                                            $long1 = $request->longitude;
            
                                            $lat2 = $value->latitude;
                                            $long2 = $value->longitude;
            
                                            $time = Googlemaps::getDistanceandTime($lat1,$long1,$lat2,$long2);
                                            
                                            $hotelimage = [];
    
                                            if(!empty($value->image))
                                            {
                                                foreach(json_decode($value->image) as $k)
                                                {
                                                    $s = url('/')."/storage/uploads/".$k;
                                                    array_push($hotelimage,$s);
                                                }
                                            }
    
                                            // $kingroom = [];
    
                                            // if(!empty($value->king_room_image))
                                            // {
                                            //     foreach(json_decode($value->king_room_image) as $d)
                                            //     {
                                            //         $p = url('/')."/storage/uploads/".$d;
                                            //         array_push($kingroom,$p);
                                            //     }
                                            // }
    
                                            // $queenroom = [];
    
                                            // if(!empty($value->queen_room_image))
                                            // {
                                            //     foreach(json_decode($value->queen_room_image) as $i)
                                            //     {
                                            //         $z = url('/')."/storage/uploads/".$i;
                                            //         array_push($queenroom,$z);
                                            //     }
                                            // }
    
                                            $temp = [
                                                'hotel_id' => $value->hotel_data_id,
                                                'user_id' => $value->user_id, 
                                                'hotel_name' => $value->hotel_name,
                                                'image' => $hotelimage,
                                                'ratings' => $value->ratings,
                                                'country' => $value->country,
                                                // 'stars' => $value->stars,
                                                'city' => $value->city,
                                                'state' => $value->state,
                                                'latitude' => $value->latitude,
                                                'longitude' => $value->longitude,
                                                'distance' => $value->distance,
                                                'time' => $time
                                            ];
                
                                            $temp['rooms'] = [
                                                [
                                                    'room_type' => "King Room",
                                                    'room_available' => $value->king_room,
                                                    // 'room_image' => $kingroom,
                                                    'room_price' => $value->king_room_price,
                                                ],
                                                [
                                                    'room_type' => "2 Queen Room",
                                                    'room_available' => $value->queen_room,
                                                    // 'room_image' => $queenroom,
                                                    'room_price' => $value->queen_room_price,
                                                ]
                                            ];
                
                                            array_push($data,$temp);
                                        }
                                    }
                                    else
                                    {
                                        if($value->queen_room > 0)
                                        {
                                            $lat1 = $request->latitude;
                                            $long1 = $request->longitude;
            
                                            $lat2 = $value->latitude;
                                            $long2 = $value->longitude;
            
                                            $time = Googlemaps::getDistanceandTime($lat1,$long1,$lat2,$long2);
                                            
                                            $hotelimage = [];
    
                                            if(!empty($value->image))
                                            {
                                                foreach(json_decode($value->image) as $k)
                                                {
                                                    $s = url('/')."/storage/uploads/".$k;
                                                    array_push($hotelimage,$s);
                                                }
                                            }
    
                                            // $kingroom = [];
    
                                            // if(!empty($value->king_room_image))
                                            // {
                                            //     foreach(json_decode($value->king_room_image) as $d)
                                            //     {
                                            //         $p = url('/')."/storage/uploads/".$d;
                                            //         array_push($kingroom,$p);
                                            //     }
                                            // }
    
                                            // $queenroom = [];
    
                                            // if(!empty($value->queen_room_image))
                                            // {
                                            //     foreach(json_decode($value->queen_room_image) as $i)
                                            //     {
                                            //         $z = url('/')."/storage/uploads/".$i;
                                            //         array_push($queenroom,$z);
                                            //     }
                                            // }
    
                                            $temp = [
                                                'hotel_id' => $value->hotel_data_id,
                                                'user_id' => $value->user_id, 
                                                'hotel_name' => $value->hotel_name,
                                                'image' => $hotelimage,
                                                'ratings' => $value->ratings,
                                                'country' => $value->country,
                                                // 'stars' => $value->stars,
                                                'city' => $value->city,
                                                'state' => $value->state,
                                                'latitude' => $value->latitude,
                                                'longitude' => $value->longitude,
                                                'distance' => $value->distance,
                                                'time' => $time
                                            ];
                
                                            $temp['rooms'] = [
                                                [
                                                    'room_type' => "King Room",
                                                    'room_available' => $value->king_room,
                                                    // 'room_image' => $kingroom,
                                                    'room_price' => $value->king_room_price,
                                                ],
                                                [
                                                    'room_type' => "2 Queen Room",
                                                    'room_available' => $value->queen_room,
                                                    // 'room_image' => $queenroom,
                                                    'room_price' => $value->queen_room_price,
                                                ]
                                            ];
                
                                            array_push($data,$temp);
                                        }
                                    }
                                }
        
                                $user = User::where(['user_id' => $request->user_id])->first();
                                $customer = Customer::where(['user_id' => $request->user_id])->first();
        
                                $ref = new BookingReference;
                                $ref->user_id = $request->user_id;
                                $ref->save();
        
                                $collect = [
                                    'user_id' => $user->user_id,
                                    'name' => $user->fname." ".$user->lname,
                                    'email' => $user->email,
                                    'number' => $customer->number,
                                    'reference_id' => $ref->booking_ref_id,
                                    'roomtype' => ($request->roomtype == 'king_room > 0') ? 1 : 2,
                                ];
                                
                                foreach($data as $value)
                                {
                                    if($value['user_id'] != 0)
                                    {
                                        $notify = User::where(['user_id' => $value['user_id']])->first();
                                        $result = Notifications::nearbyhotelNotification($notify->fcm_id, $notify->device, $collect);
                                        $rooms = Hoteldata::where(['hotel_data_id' => $value['hotel_id']])->first();
    
                                        $store = new Bookings;
                                        $store->user_id = $request->user_id;
                                        $store->hotel_owner_id = $value['user_id'];
                                        $store->hotel_id = $value['hotel_id'];
                                        $store->status = 0;
                                        $store->ref_id = $ref->booking_ref_id;
                                        $store->arrival_time = $value['time'];
                                        if($request->roomtype == "king_room > 0")
                                        {
                                            $store->roomtype = "King Room";
                                            $store->roomprice = $rooms->king_room_price == NULL ? 0 : $rooms->king_room_price;
                                            // $store->roomamenity = $rooms->king_room_amenity;
                                        }
                                        else
                                        {
                                            $store->roomtype = "2 Queen Room";
                                            $store->roomprice = $rooms->queen_room_price == NULL ? 0 : $rooms->queen_room_price;
                                            // $store->roomamenity = $rooms->queen_room_amenity;
                                        }
                                        $store->save();
                                    }
                                }
        
                                $response = [
                                    'msg' => count($nearby).' hotels available nearby your current location',
                                    'status' => 1,
                                    'notify' => 'Notification sent'
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
                                    
                                    if($request->roomtype == "king_room > 0")
                                    {
                                        if($value->king_room > 0)
                                        {
                                            $lat1 = $request->latitude;
                                            $long1 = $request->longitude;
            
                                            $lat2 = $value->latitude;
                                            $long2 = $value->longitude;
            
                                            $time = Googlemaps::getDistanceandTime($lat1,$long1,$lat2,$long2);
                                            
                                            $hotelimage = [];
    
                                            if(!empty($value->image))
                                            {
                                                foreach(json_decode($value->image) as $k)
                                                {
                                                    $s = url('/')."/storage/uploads/".$k;
                                                    array_push($hotelimage,$s);
                                                }
                                            }
    
                                            // $kingroom = [];
    
                                            // if(!empty($value->king_room_image))
                                            // {
                                            //     foreach(json_decode($value->king_room_image) as $d)
                                            //     {
                                            //         $p = url('/')."/storage/uploads/".$d;
                                            //         array_push($kingroom,$p);
                                            //     }
                                            // }
    
                                            // $queenroom = [];
    
                                            // if(!empty($value->queen_room_image))
                                            // {
                                            //     foreach(json_decode($value->queen_room_image) as $i)
                                            //     {
                                            //         $z = url('/')."/storage/uploads/".$i;
                                            //         array_push($queenroom,$z);
                                            //     }
                                            // }
    
                                            $data = [
                                                'hotel_id' => $value->hotel_data_id,
                                                'user_id' => $value->user_id,
                                                'hotel_name' => $value->hotel_name,
                                                'image' => $hotelimage,
                                                'ratings' => $value->ratings,
                                                'country' => $value->country,
                                                // 'stars' => $value->stars,
                                                'city' => $value->city,
                                                'state' => $value->state,
                                                'latitude' => $value->latitude,
                                                'longitude' => $value->longitude,
                                                'distance' => $value->distance,
                                                'direction' => $direction,
                                                'time' => $time
                                            ];
                
                                            $data['rooms'] = [
                                                [
                                                    'room_type' => "King",
                                                    'room_available' => $value->king_room,
                                                    // 'room_image' => $kingroom,
                                                    'room_price' => $value->king_room_price,
                                                ],
                                                [
                                                    'room_type' => "2 Queen",
                                                    'room_available' => $value->queen_room,
                                                    // 'room_image' =>$queenroom,
                                                    'room_price' => $value->queen_room_price,
                                                ]
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
                                    }
                                    else
                                    {
                                        if($value->queen_room > 0)
                                        {
                                            $lat1 = $request->latitude;
                                            $long1 = $request->longitude;
            
                                            $lat2 = $value->latitude;
                                            $long2 = $value->longitude;
            
                                            $time = Googlemaps::getDistanceandTime($lat1,$long1,$lat2,$long2);
                                            
                                            $hotelimage = [];
    
                                            if(!empty($value->image))
                                            {
                                                foreach(json_decode($value->image) as $k)
                                                {
                                                    $s = url('/')."/storage/uploads/".$k;
                                                    array_push($hotelimage,$s);
                                                }
                                            }
    
                                            // $kingroom = [];
    
                                            // if(!empty($value->king_room_image))
                                            // {
                                            //     foreach(json_decode($value->king_room_image) as $d)
                                            //     {
                                            //         $p = url('/')."/storage/uploads/".$d;
                                            //         array_push($kingroom,$p);
                                            //     }
                                            // }
    
                                            // $queenroom = [];
    
                                            // if(!empty($value->queen_room_image))
                                            // {
                                            //     foreach(json_decode($value->queen_room_image) as $i)
                                            //     {
                                            //         $z = url('/')."/storage/uploads/".$i;
                                            //         array_push($queenroom,$z);
                                            //     }
                                            // }
    
                                            $data = [
                                                'hotel_id' => $value->hotel_data_id,
                                                'user_id' => $value->user_id,
                                                'hotel_name' => $value->hotel_name,
                                                'image' => $hotelimage,
                                                'ratings' => $value->ratings,
                                                'country' => $value->country,
                                                // 'stars' => $value->stars,
                                                'city' => $value->city,
                                                'state' => $value->state,
                                                'latitude' => $value->latitude,
                                                'longitude' => $value->longitude,
                                                'distance' => $value->distance,
                                                'direction' => $direction,
                                                'time' => $time
                                            ];
                
                                            $data['rooms'] = [
                                                [
                                                    'room_type' => "King",
                                                    'room_available' => $value->king_room,
                                                    // 'room_image' => $kingroom,
                                                    'room_price' => $value->king_room_price,
                                                ],
                                                [
                                                    'room_type' => "2 Queen",
                                                    'room_available' => $value->queen_room,
                                                    // 'room_image' => $queenroom,
                                                    'room_price' => $value->queen_room_price,
                                                ]
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
                                    }
                                }
                                
                                $user = User::where(['user_id' => $request->user_id])->first();
                                $customer = Customer::where(['user_id' => $request->user_id])->first();
        
                                $ref = new BookingReference;
                                $ref->user_id = $request->user_id;
                                $ref->save();
        
                                $collect = [
                                    'user_id' => $user->user_id,
                                    'name' => $user->fname." ".$user->lname,
                                    'email' => $user->email,
                                    'number' => $customer->number,
                                    'building' => $customer->building,
                                    'street' => $customer->street,
                                    'landmark' => $customer->landmark,
                                    'city' => $customer->city,
                                    'state' => $customer->state,
                                    'reference_id' => $ref->booking_ref_id,
                                    'roomtype' => ($request->roomtype == 'king_room > 0') ? 1 : 2
                                ];
                            
                                if($request->direction == 1)
                                {
                                    foreach($north as $value)
                                    {
                                        if($value['user_id'] != 0)
                                        {       
                                            $notify = User::where(['user_id' => $value['user_id']])->first();
                                            $result = Notifications::nearbyhotelNotification($notify->fcm_id, $notify->device, $collect);
                                            $rooms = Hoteldata::where(['hotel_data_id' => $value['hotel_id']])->first();
    
                                            $store = new Bookings;
                                            $store->user_id = $request->user_id;
                                            $store->hotel_owner_id = $value['user_id'];
                                            $store->hotel_id = $value['hotel_id'];
                                            $store->status = 0;
                                            $store->ref_id = $ref->booking_ref_id;
                                            $store->arrival_time = $value['time'];
                                            if($request->roomtype == "king_room > 0")
                                            {
                                                $store->roomtype = "King Room";
                                                $store->roomprice = $rooms->king_room_price == NULL ? 0 : $rooms->king_room_price;
                                                // $store->roomamenity = $rooms->king_room_amenity;
                                            }
                                            else
                                            {
                                                $store->roomtype = "2 Queen Room";
                                                $store->roomprice = $rooms->queen_room_price == NULL ? 0 : $rooms->queen_room_price;
                                                // $store->roomamenity = $rooms->queen_room_amenity;
                                            }
                                            $store->save(); 
                                        }
                                    }
        
                                    $response = [
                                        'msg' => count($north).' hotels available in selected direction',
                                        'status' => 1,
                                        'notify' => 'Notification sent'
                                    ];
                                }
                                if($request->direction == 2)
                                {
                                    foreach($east as $value)
                                    {
                                        if($value['user_id'] != 0)
                                        {       
                                            $notify = User::where(['user_id' => $value['user_id']])->first();
                                            $result = Notifications::nearbyhotelNotification($notify->fcm_id, $notify->device, $collect);
                                            $rooms = Hoteldata::where(['hotel_data_id' => $value['hotel_id']])->first();
    
                                            $store = new Bookings;
                                            $store->user_id = $request->user_id;
                                            $store->hotel_owner_id = $value['user_id'];
                                            $store->hotel_id = $value['hotel_id'];
                                            $store->status = 0;
                                            $store->ref_id = $ref->booking_ref_id;
                                            $store->arrival_time = $value['time'];
                                            if($request->roomtype == "king_room > 0")
                                            {
                                                $store->roomtype = "King Room";
                                                $store->roomprice = $rooms->king_room_price == NULL ? 0 : $rooms->king_room_price;
                                                // $store->roomamenity = $rooms->king_room_amenity;
                                            }
                                            else
                                            {
                                                $store->roomtype = "2 Queen Room";
                                                $store->roomprice = $rooms->queen_room_price == NULL ? 0 : $rooms->queen_room_price;
                                                // $store->roomamenity = $rooms->queen_room_amenity;
                                            }
                                            $store->save(); 
                                        }
                                    }
        
                                    $response = [
                                        'msg' => count($east).' hotels available in selected direction',
                                        'status' => 1,
                                        'notify' => 'Notification sent'
                                    ];
                                }
                                if($request->direction == 3)
                                {
                                    foreach($south as $value)
                                    {
                                        if($value['user_id'] != 0)
                                        {       
                                            $notify = User::where(['user_id' => $value['user_id']])->first();
                                            $result = Notifications::nearbyhotelNotification($notify->fcm_id, $notify->device, $collect);
                                            $rooms = Hoteldata::where(['hotel_data_id' => $value['hotel_id']])->first();
    
                                            $store = new Bookings;
                                            $store->user_id = $request->user_id;
                                            $store->hotel_owner_id = $value['user_id'];
                                            $store->hotel_id = $value['hotel_id'];
                                            $store->status = 0;
                                            $store->ref_id = $ref->booking_ref_id;
                                            $store->arrival_time = $value['time'];
                                            if($request->roomtype == "king_room > 0")
                                            {
                                                $store->roomtype = "King Room";
                                                $store->roomprice = $rooms->king_room_price == NULL ? 0 : $rooms->king_room_price;
                                                // $store->roomamenity = $rooms->king_room_amenity;
                                            }
                                            else
                                            {
                                                $store->roomtype = "2 Queen Room";
                                                $store->roomprice = $rooms->queen_room_price == NULL ? 0 : $rooms->queen_room_price;
                                                // $store->roomamenity = $rooms->queen_room_amenity;
                                            }
                                            $store->save(); 
                                        }
                                    }
        
                                    $response = [
                                        'msg' => count($south).' hotels available in selected direction',
                                        'status' => 1,
                                        'notify' => 'Notification sent'
                                    ];
                                }
                                if($request->direction == 4)
                                {
                                    foreach($west as $value)
                                    {
                                        if($value['user_id'] != 0)
                                        {       
                                            $notify = User::where(['user_id' => $value['user_id']])->first();
                                            $result = Notifications::nearbyhotelNotification($notify->fcm_id, $notify->device, $collect);
                                            $rooms = Hoteldata::where(['hotel_data_id' => $value['hotel_id']])->first();
    
                                            $store = new Bookings;
                                            $store->user_id = $request->user_id;
                                            $store->hotel_owner_id = $value['user_id'];
                                            $store->hotel_id = $value['hotel_id'];
                                            $store->status = 0;
                                            $store->ref_id = $ref->booking_ref_id;
                                            $store->arrival_time = $value['time'];
                                            if($request->roomtype == "king_room > 0")
                                            {
                                                $store->roomtype = "King Room";
                                                $store->roomprice = $rooms->king_room_price == NULL ? 0 : $rooms->king_room_price;
                                                // $store->roomamenity = $rooms->king_room_amenity;
                                            }
                                            else
                                            {
                                                $store->roomtype = "2 Queen Room";
                                                $store->roomprice = $rooms->queen_room_price == NULL ? 0 : $rooms->queen_room_price;
                                                // $store->roomamenity = $rooms->queen_room_amenity;
                                            }
                                            $store->save(); 
                                        }
                                    }
        
                                    $response = [
                                        'msg' => count($west).' hotels available in selected direction',
                                        'status' => 1,
                                        'notify' => 'Notification sent'
                                    ];
                                }
                            }
                        }
                    }
                }
            }
        }
        catch(\Exception $e)
        {
            $response = [
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
                'status' => 0
            ];
        }

        return response()->json($response);
    }

    // public function search_hotels(Request $request)
    // {
    //     try
    //     {
    //         $hotel = $request->string;
    //         $search = Hoteldata::where('hotel_name','LIKE','%'.$hotel.'%')->get();
    //         if(count($search) > 0)
    //         {
    //             if(count($search) == 1)
    //             {
    //                 $data = [
    //                     'hotel_id' => $search->hotel_data_id,
    //                     'hotel_name' => $search->hotel_name,
    //                     'image' => ($search->image != NULL) ? $search->image : "",
    //                     'stars' => $search->stars,
    //                     'country' => $search->country,
    //                     'address' => $search->address,
    //                     'state' => $search->state,
    //                     'url' => $search->url,
    //                     'latitude' => $search->latitude,
    //                     'longitude' => $search->longitude
    //                 ];

    //                 $response = [
    //                     'msg' => count($search)." hotel availalbe",
    //                     'status' => 1,
    //                     'data' => $search
    //                 ];
    //             }
    //             else
    //             {   
    //                 $data = [];

    //                 foreach($search as $value)
    //                 {
    //                     $tmp = [
    //                         'hotel_id' => $value->hotel_data_id,
    //                         'hotel_name' => $value->hotel_name,
    //                         'image' => ($search->image != NULL) ? $search->image : "",
    //                         'stars' => $value->stars,
    //                         'country' => $value->country,
    //                         'address' => $value->address,
    //                         'state' => $value->state,
    //                         'url' => $value->url,
    //                         'latitude' => $value->latitude,
    //                         'longitude' => $value->longitude
    //                     ];

    //                     array_push($data, $tmp);
    //                 }

    //                 $response = [
    //                     'msg' => count($search)." hotels available",
    //                     'status' => 1,
    //                     'data' => $data
    //                 ];
    //             }
    //         }
    //         else
    //         {
    //             $response = [
    //                 'msg' => 'Sorry! No hotel with such name found',
    //                 'status' => 0
    //             ];
    //         }
    //     }
    //     catch(\Exception $e)
    //     {
    //         $response = [
    //             'msg' => $e->getMessage(),
    //             'status' => 0
    //         ];
    //     }

    //     return response()->json($response);
    // }

    // public function extra_code()
    // {
    //     if($request->ratings != NULL)
    //     {
    //         $nearby = DB::select( DB::raw("SELECT * ,((((acos(sin((".$request->latitude."*pi()/180)) * sin((`latitude`*pi()/180))+cos((".$request->latitude."*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((".$request->longitude."- `longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344)) as `distance` FROM `hotel_data` WHERE ".$roomtype." AND `ratings` >= $request->ratings AND `stars` IN ($stars) HAVING `distance`<= ".$request->distance." ORDER BY `distance` ASC") );
    //     }

    //     if($request->price != NULL)
    //     {
    //         // ($request->price == 1) ? (list($price1, $price2) = [0,50]) : (list($price1,$price2) = [50,100]);

    //         if($request->price == 1)
    //         {
    //             $price1 = 0;
    //             $price2 = 50;
    //         }
    //         else
    //         {
    //             $price1 = 50;
    //             $price2 = 100;
    //         }

    //         $nearby = DB::select( DB::raw("SELECT * ,((((acos(sin((".$request->latitude."*pi()/180)) * sin((`latitude`*pi()/180))+cos((".$request->latitude."*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((".$request->longitude."- `longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344)) as `distance` FROM `hotel_data` WHERE ".$roomtype." AND `stars` IN (".$stars.") AND `price` BETWEEN $price1 AND $price2 HAVING `distance`<= ".$request->distance." ORDER BY `distance` ASC") );
    //     }

    //     if($request->ratings != NULL && $request->price != NULL)
    //     {
    //         if($request->price == 1)
    //         {
    //             $price1 = 0;
    //             $price2 = 50;
    //         }
    //         else
    //         {
    //             $price1 = 50;
    //             $price2 = 100;
    //         }

    //         $nearby = DB::select( DB::raw("SELECT * ,((((acos(sin((".$request->latitude."*pi()/180)) * sin((`latitude`*pi()/180))+cos((".$request->latitude."*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((".$request->longitude."- `longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344)) as `distance` FROM `hotel_data` WHERE ".$roomtype." AND `ratings` >= ".$request->ratings." AND `stars` IN (".$stars.") AND `price` BETWEEN ".$price1." AND ".$price2." HAVING `distance`<= ".$request->distance." ORDER BY `distance` ASC") );
    //     }

    //     if($request->price != NULL && $request->amenities != NULL)
    //     {
    //         if($request->price == 1)
    //         {
    //             $price1 = 0;
    //             $price2 = 50;
    //         }
    //         else
    //         {
    //             $price1 = 50;
    //             $price2 = 100;
    //         }

    //         $amenity = explode(",",$request->amenities);
    //         $count = count($amenity);
    //         $amenities = "";
    //         for($i=0;$i<$count;$i++)
    //         {   
    //             $amenities .= 'FIND_IN_SET("'.$amenity[$i].'",`amenities`) OR ';
    //         }
    //         $amenities = rtrim($amenities,"OR ");

    //         $nearby = DB::select( DB::raw("SELECT * ,((((acos(sin((".$request->latitude."*pi()/180)) * sin((`latitude`*pi()/180))+cos((".$request->latitude."*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((".$request->longitude."- `longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344)) as `distance` FROM `hotel_data` WHERE ".$roomtype." AND ".$amenities." AND `stars` IN (".$stars.") AND `price` BETWEEN ".$price1." AND ".$price2." HAVING `distance`<= ".$request->distance." ORDER BY `distance` ASC") );
    //     }

    //     if($request->amenities != NULL && $request->ratings != NULL)
    //     {
    //         $amenity = explode(",",$request->amenities);
    //         $count = count($amenity);
    //         $amenities = "";
    //         for($i=0;$i<$count;$i++)
    //         {   
    //             $amenities .= 'FIND_IN_SET("'.$amenity[$i].'",`amenities`) OR ';
    //         }
    //         $amenities = rtrim($amenities,"OR ");

    //         $nearby = DB::select( DB::raw("SELECT * ,((((acos(sin((".$request->latitude."*pi()/180)) * sin((`latitude`*pi()/180))+cos((".$request->latitude."*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((".$request->longitude."- `longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344)) as `distance` FROM `hotel_data` WHERE ".$roomtype." AND ".$amenities." AND `ratings` >= ".$request->ratings." AND `stars` IN (".$stars.") HAVING `distance`<= ".$request->distance." ORDER BY `distance` ASC") );
    //     }

    //     if($request->amenities != NULL && $request->ratings != NULL && $request->price != NULL)
    //     {
    //         if($request->price == 1)
    //         {
    //             $price1 = 0;
    //             $price2 = 50;
    //         }
    //         else
    //         {
    //             $price1 = 50;
    //             $price2 = 100;
    //         }

    //         $amenity = explode(",",$request->amenities);
    //         $count = count($amenity);
    //         $amenities = "";
    //         for($i=0;$i<$count;$i++)
    //         {   
    //             $amenities .= 'FIND_IN_SET("'.$amenity[$i].'",`amenities`) OR ';
    //         }
    //         $amenities = rtrim($amenities,"OR ");

    //         $nearby = DB::select( DB::raw("SELECT * ,((((acos(sin((".$request->latitude."*pi()/180)) * sin((`latitude`*pi()/180))+cos((".$request->latitude."*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((".$request->longitude."- `longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344)) as `distance` FROM `hotel_data` WHERE ".$roomtype." AND ".$amenities." AND `ratings` >= ".$request->ratings." AND `stars` IN (".$stars.") AND `price` BETWEEN ".$price1." AND ".$price2." HAVING `distance`<= ".$request->distance." ORDER BY `distance` ASC") );
    //     }
    // }
}
