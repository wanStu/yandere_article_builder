<?php

use App\Http\Controllers\AdjectiveController;
use App\Http\Controllers\ArticleAssembleController;
use App\Http\Controllers\ModalParticleController;
use App\Http\Controllers\NounController;
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
Route::get('test', [ArticleAssembleController::class,"assemble"]);

Route::prefix("insert")->group(function () {
    Route::get('adjective', [AdjectiveController::class,"insert"]);
    Route::get('modal_particle', [ModalParticleController::class,"insert"]);
    Route::get('noun', [NounController::class,"insert"]);
    Route::get('verb', [VerbController::class,"insert"]);
});
