<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class CheckToken
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
        $key="list_token";
        Redis::get($key);
        $token=$_GET['token'];
        $access=Redis::sismember($key,$token);
        if($access != 1){
            $res=[
                'code'=>40025,
                'msg'=>'token过期'
            ];
            return json_encode($res,JSON_UNESCAPED_UNICODE);
        }
        return $next($request);
    }
}
