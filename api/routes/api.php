<?php

use App\Http\Controllers\API\AnswerController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\StatisticsController;
use App\Http\Controllers\API\TestController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'auth'], static function () {
    Route::post('login', [ AuthController::class, 'login']);
    Route::post('register', [ AuthController::class, 'register']);
    Route::group(['middleware' => 'auth:sanctum'], static function () {
        Route::get('user', [ AuthController::class, 'user']);
        Route::post('logout', [ AuthController::class, 'logout']);
    });
});

Route::apiResource('test', TestController::class)->middleware('auth:sanctum');
Route::apiResource('question', QuestionController::class)->middleware('auth:sanctum');
Route::apiResource('answer', AnswerController::class)->middleware('auth:sanctum');

Route::post('test-send', [TestController::class, 'saveAnswers'])->middleware('auth:sanctum');
Route::get('test/{id}/statistics', [TestController::class,'testStatistics'])->middleware('auth:sanctum');

Route::get('users',[UserController::class,'index'])->middleware('auth:sanctum');
Route::get('statistics',[StatisticsController::class,'index'])->middleware('auth:sanctum');


