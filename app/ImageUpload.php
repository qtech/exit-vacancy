<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ImageUpload extends Model
{
    public static function imageupload(Request $request, $image)
    {
        $fileNameWithExt = $request->file($image)->getClientOriginalName();
    	$fileNameWithExt = str_replace(" ", "_", $fileNameWithExt);

    	$filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
		$filename = preg_replace("/[^a-zA-Z0-9\s]/", "", $filename);
		$filename = urlencode($filename);

		$extension = $request->file($image)->getClientOriginalExtension();

		$fileNameToStore = $filename.'_'.time().'.'.$extension;
        
		$path = $request->file($image)->storeAs('/public/uploads',$fileNameToStore);
        return $fileNameToStore;
    }

    public static function multipleimageupload(Request $request, $images)
    {
        $images = $request->file('images');
        $data = 'ABCDEFGH12389IRSTUVWXYZ4567JKLMNOPQ';
        $temp = [];

        foreach($images as $image)
        {
            $i = substr(str_shuffle($data), 0, 7);
            $fileNameWithExt = $image->getClientOriginalName();
            $fileNameWithExt = str_replace(" ", "_", $fileNameWithExt);
    
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^a-zA-Z0-9\s]/", "", $filename);
            $filename = urlencode($filename);
    
            $extension = $image->getClientOriginalExtension();
    
            $fileNameToStore = $filename.$i.'.'.$extension;
            
            $path = $image->storeAs('/public/uploads',$fileNameToStore);
            array_push($temp,$fileNameToStore);
        }
        return json_encode($temp);
    }
}
