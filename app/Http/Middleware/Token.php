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
        $url_hash=substr($_SERVER['REQUEST_URI'],0,10);
        $redis_key='api:filter:url:'.$url_hash;
        //一分钟请求20次
        Redis::incr($redis_key); //自增
        Redis::expire($redis_key,60);//过期时间
        $num=Redis::get($redis_key);

        if($num>20){
            die("调用频繁，请一分钟后重试");
        }
        return $next($request);
    }
}
