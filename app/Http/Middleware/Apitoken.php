<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

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
            $token = User::find($request->id);
            if($request->header('token') == $token->remember_token)
            {
                return $next($request);
            }
            else
            {
                $response = [
                    'msg' => "Session ended! Please Login",
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
