<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\ClassController;
use App\Http\Controllers\Api\UserController;
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
// Route::post('/forgot-password', [UserController::class, 'forgotPassword']);
// Route::put('/reset-password', [UserController::class, 'updatePasswordUsingToken']);

Route::group(['middleware' => 'auth:api'], function () {
    /** For get user info from token */
    Route::get('token/user/detail', [UserController::class, 'getUserInfoFromToken']);
    /** End for get user info from token */

    /** For Teacher */
    Route::group(['prefix' => 'teacher'], function () {
        Route::get('/', [TeacherController::class, 'index']);
        Route::post('/', [TeacherController::class, 'create']);
        Route::get('{id}/show', [TeacherController::class, 'show']);
        Route::put('{id}/update', [TeacherController::class, 'update']);
        Route::delete('{id}/delete', [TeacherController::class, 'delete']);
    });
    /** End For Teacher */

    /** For Student */
    Route::group(['prefix' => 'student'], function () {
        Route::get('/', [StudentController::class, 'index']);
        Route::post('/', [StudentController::class, 'create']);
        Route::get('{id}/show', [StudentController::class, 'show']);
        Route::put('{id}/update', [StudentController::class, 'update']);
        Route::delete('{id}/delete', [StudentController::class, 'delete']);
    });
    /** End For Student */
    
    /** For Course */
    Route::group(['prefix' => 'course'], function () {
        Route::get('/', [CourseController::class, 'index']);
        Route::post('/', [CourseController::class, 'create']);
        Route::get('{id}/show', [CourseController::class, 'show']);
        Route::put('{id}/update', [CourseController::class, 'update']);
        Route::delete('{id}/delete', [CourseController::class, 'delete']);
    });
    /** End For Course */
    
    /** For Class */
    Route::group(['prefix' => 'class'], function () {
        Route::get('/', [ClassController::class, 'index']);
        Route::post('/', [ClassController::class, 'create']);
        Route::get('{id}/show', [ClassController::class, 'show']);
        Route::put('{id}/update', [ClassController::class, 'update']);
        Route::delete('{id}/delete', [ClassController::class, 'delete']);
    });
    /** End For Class */
});
