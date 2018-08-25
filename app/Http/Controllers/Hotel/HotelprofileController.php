<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hoteldata;
use App\User;
use App\Amenities;
use App\Bookings;
use Validator;
use Storage;
use App\ImageUpload;

class HotelprofileController extends Controller
{
    public function view()
    {
        $getdetails = [
            'details' => User::with('hotel')->where(['role' => 3,'user_id' => Auth()->user()->user_id])->first(),
            'amenities' => Amenities::where(['status' => 1])->get()
        ];
        
        return view('hotel_profile.main')->with('getdetails',$getdetails);
    }

    public function update(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'number' => 'required',
                'hotelclass' => 'required',
                'amenities' => 'required',
                'images' => 'nullable',
                'image' => 'nullable'
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
                $amenities = implode(",", $request->amenities);
                $hotelowner = User::where(['user_id' => Auth()->user()->user_id])->first();
                if($request->hasFile('image'))
                {
                    if($hotelowner->image != NULL)
                    {
                        Storage::delete(getenv('IMG_UPLOAD').$hotelowner->image);
                        $hotelowner->image = ImageUpload::imageupload($request,'image');
                        $hotelowner->save();
                    }
                    {
                        $hotelowner->image = ImageUpload::imageupload($request,'image');
                        $hotelowner->save();
                    }
                }

                $update = Hoteldata::where(['user_id' => Auth()->user()->user_id])->first();
                $update->number = $request->number;
                $update->stars = $request->hotelclass;

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

                $update->amenities = $amenities;
                $update->save();

                $response = [
                    'msg' => 'Hotel Profile updated',
                    'status' => 1
                ];
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

    public function hotel_images($id)
    {
        try
        {
            $images = Hoteldata::where(['user_id' => $id])->first();
            return view('hotel_profile.showimage')->with('images', $images);
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getFile()." ".$e->getLine();
        }
    }

    public function view_hotel_profile()
    {
        try
        {
            $data = [
                'bookings' => Bookings::with('user')->where(['hotel_owner_id' => Auth()->user()->user_id])->get(),
                'hoteluser' => User::with('hotel')->where(['user_id' => Auth()->user()->user_id])->first()
            ];
            return view('hotel_profile.view')->with($data);
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getFile()." ".$e->getLine();
        }
    }
}
