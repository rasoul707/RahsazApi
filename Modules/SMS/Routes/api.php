<?php

Route::group(['middleware' => [], 'prefix' => '/admin/sms'], function () {
    Route::post('/send-single-sms', [\Modules\SMS\Http\Controllers\Admin\SMSController::class, 'sendSingleSms']);
    Route::post('/send-group-sms', [\Modules\SMS\Http\Controllers\Admin\SMSController::class, 'sendGroupSms']);
    Route::get('/latest-group-sms', [\Modules\SMS\Http\Controllers\Admin\SMSController::class, 'latestGroupSms']);
});
