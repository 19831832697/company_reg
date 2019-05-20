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
Route::get('company','company\CompanyController@company');
Route::post('companyDo','company\CompanyController@companyDo');

Route::get('audit','verify\VerifyController@audit');
Route::post('pass','verify\VerifyController@pass');
Route::post('reject','verify\VerifyController@reject');
Route::get('status','company\CompanyController@status');

Route::get('show','company\CompanyController@show')->middleware('token');
Route::post('accessToken','verify\VerifyController@accessToken');
