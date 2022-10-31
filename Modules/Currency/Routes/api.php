<?php


Route::group(['middleware' => [], 'prefix' => '/admin/currencies'], function () {
    Route::get('/', [\Modules\Currency\Http\Controllers\Admin\CurrencyController::class, 'index']);
    Route::post('/store', [\Modules\Currency\Http\Controllers\Admin\CurrencyController::class, 'store']);
    Route::get('/show/{id}', [\Modules\Currency\Http\Controllers\Admin\CurrencyController::class, 'show']);
    Route::put('/update/{id}', [\Modules\Currency\Http\Controllers\Admin\CurrencyController::class, 'update']);
    Route::delete('/destroy/{id}', [\Modules\Currency\Http\Controllers\Admin\CurrencyController::class, 'destroy']);
});
