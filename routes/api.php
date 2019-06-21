<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->prefix('v1')->middleware('cors')->group(function () {
    //api
    Route::middleware('api.guard')->group(function () {
            //用户注册
            Route::post('/login', 'UserController@login')->name('users.login');
        Route::post('/users', 'UserController@store')->name('users.store');
            Route::middleware('api.refresh')->group(function () {
                Route::get('/users/info', 'UserController@info')->name('users.info');

                Route::get('/users', 'UserController@index')->name('users.index');
                Route::get('/users/{user}', 'UserController@show')->name('users.show');
                Route::get('/logout', 'UserController@logout')->name('users.logout');
            });
    });

    //admin
    Route::middleware('admin.guard')->group(function () {
        //管理员登录
        Route::post('/admin/login', 'AdminController@login')->name('admins.login');
        Route::post('/admins', 'AdminController@store')->name('admins.store');
        Route::middleware('admin.refresh')->group(function () {
            //当前管理员信息
            Route::get('/admins/info', 'AdminController@info')->name('admins.info');
            //管理员列表
            Route::get('/admins', 'AdminController@index')->name('admins.index');
            //管理员信息
            Route::get('/admins/{user}', 'AdminController@show')->name('admins.show');
            //管理员退出
            Route::get('/admins/logout', 'AdminController@logout')->name('admins.logout');

        });
    });
});

