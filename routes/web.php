<?php

use App\Http\Controllers\AdjectiveController;
use App\Http\Controllers\ArticleAssembleController;
use App\Http\Controllers\ModalParticleController;
use App\Http\Controllers\NounController;
use App\Http\Controllers\PuncListController;
use App\Http\Controllers\VerbController;
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

Route::get('/', function () {
    return view('index');
});
Route::post('assemble', [ArticleAssembleController::class,"assemble"]);

Route::prefix("insert")->group(function () {
    Route::post('adjective', [AdjectiveController::class,"insert"]);
    Route::post('modal_particle', [ModalParticleController::class,"insert"]);
    Route::post('noun', [NounController::class,"insert"]);
    Route::post('verb', [VerbController::class,"insert"]);
    Route::post('punc_list', [PuncListController::class,"insert"]);
});

Route::prefix("get_list")->group(function () {
    Route::post('adjective', [AdjectiveController::class,"getList"]);
    Route::post('modal_particle', [ModalParticleController::class,"getList"]);
    Route::post('noun', [NounController::class,"getList"]);
    Route::post('verb', [VerbController::class,"getList"]);
    Route::post('punc_list', [PuncListController::class,"getList"]);
});

Route::post("get_component_list",[ArticleAssembleController::class,"getComponentList"]);
Route::get("get_csrf_token",function () {
    return json_encode(["status" => 200,"message" => "获取成功","data" => csrf_token()],JSON_UNESCAPED_UNICODE);
});
