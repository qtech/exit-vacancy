<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hoteldata;
use App\User;
use Validator;
use Storage;
use App\ImageUpload;

class HotelImagesController extends Controller
{
    public function get_hotel_images(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'hotel_id' => 'required'
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
                $update = Hoteldata::where(['hotel_data_id' => $request->hotel_id])->first();

                $images = [];

                if(count($update) > 0)
                {
                    if(!empty($update->image))
                    {
                        foreach(json_decode($update->image) as $image)
                        {
                            $tmp =  url("/")."/storage/uploads/".$image;
                            array_push($images,$tmp);
                        }
                    }
                    else
                    {
                        $response = [
                            'msg' => 'No images available for this hotel',
                            'status' => 1
                        ];
                    }

                    $response = [
                        'msg' => 'Hotel Images',
                        'status' => 1,
                        'images' => $images
                    ];
                }
                else
                {
                    $response = [
                        'msg' => 'No records found!',
                        'status' => 1
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

    public function update_hotel_images(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'images' => 'required',
                'hotel_id' => 'required'
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
                $update = Hoteldata::where(['hotel_data_id' => $request->hotel_id])->first();

                if($request->hasFile('images'))
                {
                    if(!empty($update->image))
                    {
                        foreach(json_decode($update->image) as $image)
                        {
                            Storage::delete(getenv('IMG_UPLOAD').$image);
                        }
                        $update->image = ImageUpload::multipleimageupload($request,'images');
                    }
                    else
                    {
                        $update->image = ImageUpload::multipleimageupload($request,'images');
                    }
                }

                $update->save();

                $response = [
                    'msg' => 'Hotel Images updated',
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
}
