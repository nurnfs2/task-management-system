<?php

use App\Http\Controllers\API\TaskController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

    Route::group(['namespace' => 'App\Http\Controllers\API'], function () {
        // --------------- Register and Login ----------------//
        Route::post('register', 'AuthenticationController@register')->name('register');
        Route::post('login', 'AuthenticationController@login')->name('login');

        // ------------------ Get Data ----------------------//
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('get-user', 'AuthenticationController@userInfo')->name('get-user');
            Route::post('logout', 'AuthenticationController@logOut')->name('logout');
        });
    });





    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/tasks', [TaskController::class, 'index']);
        Route::post('/tasks', [TaskController::class, 'store']);
        Route::get('/tasks/{task}', [TaskController::class, 'show']);
        Route::put('/tasks/{task}', [TaskController::class, 'update']);
        Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
    });


});
