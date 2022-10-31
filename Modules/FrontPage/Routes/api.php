<?php
Route::group(['middleware' => [], 'prefix' => '/admin/page'], function () {
    Route::get('/index', [\Modules\FrontPage\Http\Controllers\Admin\FrontPageController::class, 'index']);
    Route::get('/show/{id}', [\Modules\FrontPage\Http\Controllers\Admin\FrontPageController::class, 'show']);
    Route::put('/update/{id}', [\Modules\FrontPage\Http\Controllers\Admin\FrontPageController::class, 'update']);
    Route::post('/store', [\Modules\FrontPage\Http\Controllers\Admin\FrontPageController::class, 'store']);
    Route::delete('/destroy/{id}', [\Modules\FrontPage\Http\Controllers\Admin\FrontPageController::class, 'destroy']);
});
