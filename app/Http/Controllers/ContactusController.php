<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contactus;
use Validator;

class ContactusController extends Controller
{
    public function view()
    {
        try
        {
            $contact = Contactus::find(1);
            return view('contactus.main')->with('contact', $contact);
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }

    public function update(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'email' => 'required',
                'address' => 'required',
                'phone' => 'required'
            ]);

            if($validator->fails())
            {
                $response = [
                    'msg' => 'Please fill the empty fields',
                    'status' => 0
                ];
            }   
            else
            {
                $contact = Contactus::find(1);
                $contact->email = $request->email;
                $contact->address = $request->address;
                $contact->number = $request->phone;
                $contact->save();

                $contactus = Contactus::find(1);

                $response = [
                    'msg' => 'Contact Us details updated',
                    'status' => 1,
                    'data' => $contactus
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
