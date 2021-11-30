<?php

use App\Http\Controllers\AdjectiveController;
use App\Http\Controllers\ArticleAssembleController;
use App\Http\Controllers\ModalParticleController;
use App\Http\Controllers\NounController;
use App\Http\Controllers\PuncListController;
use App\Http\Controllers\ComponentController;
use Illuminate\Support\Facades\Route;

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

//主页
Route::get('/', function () {
    return view('index');
});
//组装文章
Route::match(["post","get"],'assemble', [ArticleAssembleController::class,"assemble"]);

//插入文章组成词语
Route::prefix("insert")->group(function () {
    Route::post('Component', [ComponentController::class,"insert"]);
});

//获取单个文章组成词语列表
Route::prefix("get_list")->group(function () {
    Route::post('Component', [ComponentController::class,"getList"]);
});
//获取所有文章组成词语列表
Route::post("get_component_list",[ArticleAssembleController::class,"getComponentList"]);
//获取csrf token
Route::get("get_csrf_token",function () {
    return json_encode(["status" => 200,"message" => "获取成功","data" => csrf_token()],JSON_UNESCAPED_UNICODE);
});
