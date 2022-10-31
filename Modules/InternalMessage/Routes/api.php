<?php


Route::group(['middleware' => [], 'prefix' => '/admin/internal-message'], function () {
    Route::post('/send', [\Modules\InternalMessage\Http\Controllers\Admin\InternalMessageController::class, 'send']);
});

