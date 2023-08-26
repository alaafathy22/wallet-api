<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['checkPassword'], 'namespace' => 'App\Http\Controllers\Api'], function () {
    Route::post('HomePage', 'Home@con_show');
    Route::post('SignUp', 'SignUp@creatUser');
    Route::get('LogOut', 'LogoutApi@LogOut');
    Route::get('Delete_Content', 'Delete_Content@Delete_Content');
    Route::get('Edit_Content_For_User', 'Edit_Content@Edit_Content_For_User')->middleware('assinGuard:api');
    Route::get('Input_contents_for_user', 'Input_contents@Input_contents_for_user')->middleware('assinGuard:api');
    Route::get('creat_wallet', 'creat_wallet@creat_wallet')->middleware('assinGuard:api');
});










Route::get('test', 'App\Http\Controllers\Controller@test')->name('test');
