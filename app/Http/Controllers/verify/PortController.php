<?php

namespace App\Http\Controllers\verify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class PortController extends Controller
{
    /**
     * 获取主机ip
     * @return false|string
     */
    public function getIp(){
        $res=[
            'code'=>0,
            'msg'=>'ok',
            'data'=>[
                'ip'=>$_SERVER['REMOTE_ADDR']
            ]
        ];
        return json_encode($res,JSON_UNESCAPED_UNICODE);
    }

    /**
     * 获取ua
     * @return false|string
     */
    public function getUa(){
        $res=[
            'code'=>0,
            'msg'=>'ok',
            'data'=>[
                'ip'=>$_SERVER['HTTP_USER_AGENT']
            ]
        ];
        return json_encode($res,JSON_UNESCAPED_UNICODE);
    }

    /**
     * 生成accessToken
     * @return string
     */
    public function accessToken(){
        $arrInfo=file_get_contents("php://input");
        $data=json_decode($arrInfo,true);
        $appid=$data['appid'];
        $app_key=$data['key'];
        if(empty($appid) || empty($app_key)){
            $res=[
                'code'=>40025,
                'msg'=>'参数不全'
            ];
            return json_encode($res,JSON_UNESCAPED_UNICODE);
        }
        $info=DB::table('api')->where('appid',$appid)->first();
        if($info){
            if($info->key == $app_key){
                $key="ip:".$_SERVER['REMOTE_ADDR']."token$appid";
                $token=Redis::get($key);
                if(empty($token)){
                    $access="$app_key".rand(100000,999999);
                    Redis::set($key,$access);
                    Redis::expire($key,3600);
                }
                return $key;
            }else{
                $res=[
                    'code'=>40025,
                    'msg'=>'key值不匹配'
                ];
                return json_encode($res,JSON_UNESCAPED_UNICODE);
            }
        }else{
            $res=[
                'code'=>40025,
                'msg'=>'appid不匹配'
            ];
            return json_encode($res,JSON_UNESCAPED_UNICODE);
        }
    }
}
