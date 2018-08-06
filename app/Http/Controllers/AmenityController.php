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
            return view('amenities.view');
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

    public function disable(Request $request)
    {
        try
        {
            $disable = Amenities::find($request->id);
            $disable->status = $disable->status == 0 ? 1 : 0;
            $disable->save();

            if($disable->status == 1)
            {
                $response = [
                    'msg' => 'Amenity Enabled',
                    'status' => 1
                ];
            }
            else
            {
                $response = [
                    'msg' => 'Amenity Disabled',
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
