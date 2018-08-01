<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Amenities;

class AmenityController extends Controller
{
    public function getData()
    {
        $amenity = Amenities::take(8)->get();
        
        $response = [
            'msg' => 'All the Amenities',
            'status' => 1,
            'data' => $amenity
        ];

        return response()->json($response);
    }

    public function view()
    {
        try
        {
            return view('amenities.main');
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'amenities' => 'required'
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
            $amenities = implode(",",$request->amenities);
            $amenity = explode(",", $amenities);

            foreach($amenity as $value)
            {
                $new_amenity = new Amenities;
                $new_amenity->amenity_name = $value;
                $new_amenity->save();
            }

            $data = Amenities::all();

            $response = [
                'msg' => 'New Amenities added',
                'status' => 1,
                'data' => $data
            ];
        }

        return response()->json($response);
    }

    public function delete(Request $request)
    {
        try
        {
            $delete = Amenities::find($request->id)->delete();

            $response = [
                'msg' => 'Amenity Deleted successfully',
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
