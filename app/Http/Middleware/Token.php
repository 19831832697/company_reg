<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class Token
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
        $key="ip:".$_SERVER['REMOTE_ADDR']."HTTP_USER_AGENT:".$_SERVER['HTTP_USER_AGENT']."token"."$request->input('token')";

        $num=Redis::get($key);

        Redis::incr($key);

        if($num>=5){
            die("调用频繁，请一分钟后重试");
        }
        Redis::expire($key,20);
        return $next($request);
    }
}
