<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Query;

class QueryController extends Controller
{
    public function view()
    {
        try
        {
            $queries = Query::all();
            return view('query.main')->with('queries', $queries);
        }
        catch(\Exception $e)
        {
            return $e->getMessage()." ".$e->getLine();
        }
    }
}
