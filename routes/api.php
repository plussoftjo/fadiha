<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'user'], function () {
    Route::post('login','App\Http\Controllers\Api\AuthController@login');
    Route::post('register','App\Http\Controllers\Api\AuthController@register');
    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('/auth', 'App\Http\Controllers\Api\AuthController@auth');
    });
});


Route::group(['prefix' => 'post'], function () {
    Route::post('store','App\Http\Controllers\Api\PostController@store');
    Route::post('like','App\Http\Controllers\Api\PostController@LikeController');
    Route::post('comment','App\Http\Controllers\Api\PostController@CommentController');
    Route::post('remove','App\Http\Controllers\Api\PostController@removePost');
    
});

Route::post('main/index','App\Http\Controllers\Api\MainController@index');

Route::get('main/stramvideo/{id}','App\Http\Controllers\Api\MainController@stramvideo');