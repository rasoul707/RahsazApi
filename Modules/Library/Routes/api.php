<?php

Route::group(['middleware' => [], 'prefix' => '/admin/library'], function () {
    Route::group(['prefix' => '/images'], function () {
        Route::get('/index', [\Modules\Library\Http\Controllers\Admin\ImageController::class, 'index']);
        Route::get('/show/{id}', [\Modules\Library\Http\Controllers\Admin\ImageController::class, 'show']);
        Route::post('/store', [\Modules\Library\Http\Controllers\Admin\ImageController::class, 'store']);
        Route::delete('/destroy/{id}', [\Modules\Library\Http\Controllers\Admin\ImageController::class, 'destroy']);
        Route::put('/update/{id}', [\Modules\Library\Http\Controllers\Admin\ImageController::class, 'update']);
    });

    Route::group(['prefix' => '/videos'], function () {
        Route::get('/index', [\Modules\Library\Http\Controllers\Admin\VideoController::class, 'index']);
        Route::get('/show/{id}', [\Modules\Library\Http\Controllers\Admin\VideoController::class, 'show']);
        Route::post('/store', [\Modules\Library\Http\Controllers\Admin\VideoController::class, 'store']);
        Route::delete('/destroy/{id}', [\Modules\Library\Http\Controllers\Admin\VideoController::class, 'destroy']);
        Route::put('/update/{id}', [\Modules\Library\Http\Controllers\Admin\VideoController::class, 'update']);
    });
});

