<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Query;
use Validator;

class QueryController extends Controller
{
    public function storequery(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'subject' => 'required',
                'email' => 'required',
                'message' => 'required'
            ]);

            if($validator->fails())
            {
                $response = [
                    'msg' => 'Oops! Some field is empty',
                    'status' => 0
                ];
            }
            else
            {
                $query = Query::create($request->all());

                $response = [
                    'msg' => 'Your query sent to the admin successfully',
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
