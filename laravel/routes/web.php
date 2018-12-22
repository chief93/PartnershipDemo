<?php
use Illuminate\Support\Facades\Route;

Route::get('/user/balance/resupply', 'User\Balance\ResupplyController@Get')->middleware('auth')->name('/user/balance/resupply');
Route::post('/user/balance/resupply', 'User\Balance\ResupplyController@Post')->middleware('auth')->name('/user/balance/resupply');
Route::get('/user/register/{promo?}', 'User\RegisterController@Get')->name('/user/register');
Route::post('/user/register/{promo?}', 'User\RegisterController@Post')->name('/user/register');
Route::get('/user/login', 'User\LoginController@Get')->name('/user/login');
Route::post('/user/login', 'User\LoginController@Post')->name('/user/login');
Route::get('/user/logout', 'User\LogoutController@Get')->name('/user/logout');
Route::get('/user/{id?}', 'User\IndexController@Get')->name('/user');
Route::get('/', 'IndexController@Get')->name('/');