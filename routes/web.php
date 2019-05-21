<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//注册  注册执行
Route::get('company','company\CompanyController@company')->middleware('auth');
Route::post('companyDo','company\CompanyController@companyDo');
//后台审核
Route::get('audit','verify\VerifyController@audit');
//审核通过  失败
Route::post('pass','verify\VerifyController@pass');
Route::post('reject','verify\VerifyController@reject');
//查看审核状态
Route::post('status','company\CompanyController@status');
Route::get('u_status','company\CompanyController@u_status');
//生成AccessToken  中间件验证请求次数
Route::get('show','company\CompanyController@show')->middleware('token');
Route::post('accessToken','verify\PortController@accessToken');
//获取主机ip,ua,用户注册信息
Route::middleware('token','checktoken')->group(function(){
    Route::get('getIp','verify\PortController@getIp');
    Route::get('getUa','verify\PortController@getUa');
});

Route::get('getRegInfo','verify\PortController@getRegInfo');
//Route::get('aa','verify\PortController@aa')->middleware('token');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
