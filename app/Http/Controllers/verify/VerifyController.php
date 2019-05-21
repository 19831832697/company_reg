<?php

namespace App\Http\Controllers\verify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class VerifyController extends Controller
{
    /**
     * 后台审核
     * @param Request $request
     */
    public function audit(Request $request){
        $data=DB::table('api')->get();
        return view('verify',['data'=>$data]);
    }

    /**
     * 审核通过
     * @param Request $request
     * @return false|string
     */
    public function pass(Request $request){
        $company_id=$request->input();
        $where=[
            'company_id'=>$company_id
        ];
        $app_id = Str::random(20);
        $u_key = Str::random(11) . md5("keys");
        $arrInfo=DB::table('api')->where($where)->first();
        $appid=$arrInfo->appid;
        $key=$arrInfo->key;
        if(empty($appid) || empty($key)){
            $updateInfo=[
                'appid'=>$app_id,
                'key'=>$u_key,
                'status'=>2
            ];
            $dataInfo=DB::table('api')->where($where)->update($updateInfo);
            if($dataInfo){
                $res=[
                    'code'=>'200',
                    'msg'=>'审核通过'
                ];
                return json_encode($res,JSON_UNESCAPED_UNICODE);
            }
        }else{
            $res=[
                'code'=>'20020',
                'msg'=>'审核已通过'
            ];
            return json_encode($res,JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 审核驳回
     * @param Request $request
     * @return false|string
     */
    public function reject(Request $request){
        $company_id=$request->input();
        $where=[
            'company_id'=>$company_id
        ];
        $data=DB::table('api')->where($where)->first();
        $appid=$data->appid;
        $key=$data->key;
        if(!empty($appid) && !empty($key)){
            $res=[
                'code'=>'200',
                'msg'=>'审核已通过'
            ];
            return json_encode($res,JSON_UNESCAPED_UNICODE);
        }else{
            $res=[
                'code'=>'40020',
                'msg'=>'审核驳回'
            ];
            return json_encode($res,JSON_UNESCAPED_UNICODE);
        }
    }
}
