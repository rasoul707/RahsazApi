<?php

use Illuminate\Http\Request;

Route::group(['middleware' => [], 'prefix' => '/admin/blog'], function () {
    Route::get('/index', [\Modules\Blog\Http\Controllers\Admin\BlogController::class, 'index']);
    Route::post('/store', [\Modules\Blog\Http\Controllers\Admin\BlogController::class, 'store']);
    Route::put('/update/{id}', [\Modules\Blog\Http\Controllers\Admin\BlogController::class, 'update']);
    Route::get('/show/{id}', [\Modules\Blog\Http\Controllers\Admin\BlogController::class, 'show']);
    Route::delete('/destroy/{id}', [\Modules\Blog\Http\Controllers\Admin\BlogController::class, 'destroy']);
    Route::put('/update-status/{id}', [\Modules\Blog\Http\Controllers\Admin\BlogController::class, 'updateStatus']);
});




Route::group(['middleware' => [], 'prefix' => '/blog'], function () {
    Route::get('/index', [\Modules\Blog\Http\Controllers\BlogController::class, 'index']);
    Route::get('/show/{id}', [\Modules\Blog\Http\Controllers\BlogController::class, 'show']);
});
