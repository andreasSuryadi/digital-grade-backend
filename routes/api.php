<?php

use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\StudentController;
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [UserController::class, 'forgotPassword']);
Route::put('/reset-password', [UserController::class, 'updatePasswordUsingToken']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'teacher'], function () {
        Route::get('/', [TeacherController::class, 'index']);
        Route::post('/', [TeacherController::class, 'create']);
        Route::get('{id}/show', [TeacherController::class, 'show']);
        Route::put('{id}/update', [TeacherController::class, 'update']);
        Route::delete('{id}/delete', [TeacherController::class, 'delete']);
    });
    Route::group(['prefix' => 'student'], function () {
        Route::get('/', [StudentController::class, 'index']);
        Route::post('/', [StudentController::class, 'create']);
        Route::get('{id}/show', [StudentController::class, 'show']);
        Route::put('{id}/update', [StudentController::class, 'update']);
        Route::delete('{id}/delete', [StudentController::class, 'delete']);
    });
});
