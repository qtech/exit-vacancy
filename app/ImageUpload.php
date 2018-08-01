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
}
