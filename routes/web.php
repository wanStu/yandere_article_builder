<?php
use App\Http\Controllers\ComponentController;
use Illuminate\Support\Facades\Route;
use App\Http\Services\CommonService;
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
//获取csrf token
//Route::get("get_csrf_token",function () {
//    return (new common())->returnJson(200,"获取成功",csrf_token());
//});
//登录 login
//Route::post('/admin/login', [Login::class,"login"]);

//需要验证 token 的路由
//Route::middleware("VerifyUserToken")->group(function () {
//    //插入文章组成词语
//    Route::prefix("insert")->group(function () {
//        Route::match(["post","get"],'Component', [ComponentController::class,"insert"]);
//    });
//});


