<?php

use App\Http\Controllers\ArticleAssembleController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Services\CommonService;



//获取csrf token
Route::get("get_csrf_token",[CommonService::class,"getCsrfTokne"]);
//登录 login
Route::post('/admin/login', [LoginController::class,"login"]);
//未登录提示
Route::match(["post","get"],'/admin/unlogin', function () {
    return (new CommonService())->returnJson(400,"未登录或登陆已过期",false);
});
//组装文章
Route::match(["post","get"],'assemble', [ArticleAssembleController::class,"assemble"]);

//注册用户
Route::match(["post","get"],"register_user",[UserController::class,"addUser"]);
//Route::match(["post","get"],"register_user",function () {
//    return (new CommonService())->returnJson(400,"注册暂未开启",false);
//});

//需要验证 token 的路由
Route::middleware("VerifyUserToken")->group(function () {

    //获取单个文章组成词语列表
    Route::prefix("get_list")->group(function () {
        Route::match(["post","get"],'Component', [ComponentController::class,"getList"]);
    });

    //插入文章组成词语
    Route::prefix("insert")->group(function () {
        Route::match(["post","get"],'Component', [ComponentController::class,"insert"]);
    });

    //获取所有文章组成词语列表
    Route::match(["post","get"],"get_component_list",[ArticleAssembleController::class,"getComponentList"]);

    //用户操作
    Route::prefix("user")->group(function () {
        //新增
        Route::match(["post","get"],"add_user",[UserController::class,"addUser"]);
        //编辑
        Route::match(["post","get"],"edit_user",[UserController::class,"editUser"]);
        //删除
        Route::match(["post","get"],"del_user",[UserController::class,"delUser"]);
    });
});



