<?php

namespace App\Http\Controllers\verify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
     * 获取用户注册信息
     * @return false|string
     */
    public function getRegInfo(){
        $uid=$_GET['uid'];
        $dataInfo=DB::table('api')->where('uid',$uid)->first();
        $res=[
            'code'=>200,
            'msg'=>'ok',
            'data'=>$dataInfo
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
                $num=Redis::incr($key);
                Redis::expire($key,3600);
                if($num>100){
                    $res=[
                        'code'=>40025,
                        'msg'=>'调用频繁，请一小时后重试'
                    ];
                    return json_encode($res,JSON_UNESCAPED_UNICODE);
                }else{
                    $access_token=(md5(str::random(20)));
                    $key="list_token";
                    Redis::sadd($key,$access_token);
                    Redis::expire($key,3600);
                    $res=[
                        'res'=>'200',
                        'data'=>$access_token
                    ];
                    die(json_encode($res,JSON_UNESCAPED_UNICODE)) ;
                }
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
