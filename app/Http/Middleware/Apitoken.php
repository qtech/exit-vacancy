<?php

namespace App\Http\Middleware;

use Closure;

class Apitoken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!empty($request->header('token')))
        {
            if($request->header('token') == '11Z1yzMEte4w6T1Pktpk')
            {
                return $next($request);
            }
            else
            {
                $response = [
                    'msg' => "Please give Apitoken to access API's",
                    'status' => 0
                ];

                return response()->json($response);
            }
        }
        else
        {
            $response = [
                'msg' => "Not Authenticated",
                'status' => 0
            ];

            return response()->json($response);
        }
        
    }
}
