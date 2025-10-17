<?php

use App\Http\Controllers\API\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function(){
    Route::resource('tasks', TaskController::class);
});


Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
