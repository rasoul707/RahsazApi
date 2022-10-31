<?php



Route::group(['middleware' => [], 'prefix' => '/admin/dashboard'], function () {
    Route::get('/index', [\Modules\Dashboard\Http\Controllers\Admin\DashboardController::class, 'index']);
});

