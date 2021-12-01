<?php

use App\Http\Controllers\ArticleAssembleController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\Login;
use Illuminate\Support\Facades\Route;
use App\Http\Services\common;



//获取csrf token
Route::get("get_csrf_token",[common::class,"getCsrfTokne"]);
//登录 login
Route::post('/admin/login', [Login::class,"login"]);
//未登录提示
Route::match(["post","get"],'/admin/unlogin', function () {
    return (new common())->returnJson(400,"未登录或登陆已过期",false);
});
//组装文章
Route::match(["post","get"],'assemble', [ArticleAssembleController::class,"assemble"]);

//需要验证 token 的路由
Route::middleware("VerifyUserToken")->group(function () {
    //获取单个文章组成词语列表
    Route::prefix("get_list")->group(function () {
        Route::match(["post","get"],'Component', [ComponentController::class,"getList"]);
    });
    //获取所有文章组成词语列表
    Route::match(["post","get"],"get_component_list",[ArticleAssembleController::class,"getComponentList"]);

    //插入文章组成词语
    Route::prefix("insert")->group(function () {
        Route::match(["post","get"],'Component', [ComponentController::class,"insert"]);
    });
});



