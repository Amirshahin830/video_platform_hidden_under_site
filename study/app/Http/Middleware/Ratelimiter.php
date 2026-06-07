<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class Ratelimiter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'rate_limite:'. $request->ip();
        $max_try = 5;
        $max_secound = 60 ;

        $attempts = Redis::incr($key);

        if ($attempts == 1 ) {
            Redis::expire($key , $max_secound);
        }

        if ($attempts > $max_try ) {
            return response()->json([
                'message ' => 'Too many requests'
            ],429);
        }
        return $next($request);
    }
}
