<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class loginUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        //return $next($request);
        if(auth('api')->check()){
            return $next($request);
        }else{
            return response()->json(
                [
                    'status'    => false,
                    'message'   => 'Login Required'
                ],401);
        }
    }
}
