<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Storage;
use App\ImageUpload;

class CommonImageController extends Controller
{
    public function storeImage(Request $request)
    {
        try
        {
            if($request->hasFile('image'))
            {
                $response = [
                    'msg' => 'Image upload successful',
                    'status' => 1,
                    'image' => ImageUpload::imageupload($request,'image')
                ];
            }

            if($request->hasFile('images'))
            {
                $images = ImageUpload::multipleimageupload($request,'images');

                $response = [
                    'msg' => 'Image upload successful',
                    'status' => 1,
                    'images' => json_decode($images)
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
}
