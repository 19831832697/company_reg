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
Route::get('company','company\CompanyController@company');
Route::post('companyDo','company\CompanyController@companyDo');

Route::get('audit','verify\VerifyController@audit');
//审核通过  失败
Route::post('pass','verify\VerifyController@pass');
Route::post('reject','verify\VerifyController@reject');
//查看审核状态
Route::post('status','company\CompanyController@status');
Route::get('u_status','company\CompanyController@u_status');

//生成AccessToken  中间件验证请求次数
Route::get('show','company\CompanyController@show')->middleware(['token','verify']);
Route::post('accessToken','verify\VerifyController@accessToken');
//获取主机ip
Route::post('ip','company\CompanyController@ip');
Route::post('getIp','verify\VerifyController@getIp');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
