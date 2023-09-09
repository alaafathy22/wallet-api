<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['checkPassword'], 'namespace' => 'App\Http\Controllers\Api'], function () {
    Route::post('LoginPage', 'Login_Controller@login_con');
    Route::post('HomePage', 'Home@con_show')->middleware('assinGuard:api');
    Route::post('create_wallet', 'create_wallet@create_wallet_fun')->middleware('assinGuard:api');
    Route::post('enterValueForWallets', 'enterValueForWallets@enterValueForWallets_fun')->middleware('assinGuard:api');
    Route::post('LogOut', 'LogoutApi@LogOut');
    Route::post('Delete_Content', 'Delete_Content@Delete_Content')->middleware('assinGuard:api');
    Route::post('Edit_Content', 'Edit_Content@Edit_Content_fun')->middleware('assinGuard:api');
    Route::post('SignUp', 'SignUp@creatUser');
});









Route::get('test', 'App\Http\Controllers\Controller@test')->name('test');
