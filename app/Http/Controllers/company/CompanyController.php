<?php

namespace App\Http\Controllers\company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    /**
     * 显示视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function company(){
        return view('reg');
    }

    /**
     * 注册执行
     * @param Request $request
     */
    public function companyDo(Request $request)
    {
        $company_name = $request->input('company_name');
        $company_user = $request->input('company_user');
        $company_account = $request->input('company_account');
        $company_pub = $request->input('company_pub');
        $company_img = $request->input('company_img');
        $company_img=$this->img($request,'company_img');
        $ip=$_SERVER['REMOTE_ADDR'];
        $data=[
            'company_name'=>$company_name,
            'company_user'=>$company_user,
            'company_account'=>$company_account,
            'company_pub'=>$company_pub,
            'company_img'=>$company_img,
            'ip'=>$ip
        ];
        $data = DB::table('api')->insert($data);
        if($data){
           echo "提交成功，等待审核";
        }
    }

    /**
     * 文件上传
     * @param Request $request
     * @param $file
     * @return false|string
     */
    public function img(Request $request,$file){
        if ($request->hasFile($file) && $request->file($file)->isValid()) {
            $photo = $request->file($file);
            $store_result = $photo->store('uploads/'.date('Ymd'));
            return $store_result;
        }

    }

    /**
     * 查看审核状态
     */
    public function status(){
        $ip=$_SERVER['REMOTE_ADDR'];
        $data=DB::table('api')->where('ip',$ip)->first();
        if($data){
            $appid=$data->appid;
            $key=$data->key;
            if(!empty($appid) && !empty($key)){
                echo "审核通过";echo "<br/>";
                echo "APPID:".$appid;
                echo "<br/>";
                echo "key:".$key;
            }else{
                echo "审核中";
            }

        }
    }
    /**
     * 调用AccessToken
     */
    public function show(){
        $appid="cOp40jNNOZprHMHLgqjN";
        $key="zkWXJJLvwmn14f802e1fba977727845e8872c1743a7";
        $dataInfo=[
            'appid'=>$appid,
            'key'=>$key
        ];
        $data=json_encode($dataInfo);
        $url="http://vm.laravel.com/accessToken";
        $ch=curl_init($url);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);
        $res=curl_exec($ch);
        $u_key="$appid"."token";
        $token=Redis::get($u_key);
        if(empty($token)){
            Redis::set($u_key,$res);
            Redis::expire($key,20);
        }
        echo $res;
    }
}