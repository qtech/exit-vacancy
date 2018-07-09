<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;

class excelController extends Controller
{
    public function excel(Request $request)
    {
        $file = Excel::load('hotels1.csv')->get();
        return $file;
    }
}
