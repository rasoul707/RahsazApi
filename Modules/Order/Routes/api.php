<?php


Route::group(['middleware' => [], 'prefix' => '/admin/orders'], function () {
    Route::get('/index', [\Modules\Order\Http\Controllers\Admin\OrderController::class, 'index']);
    Route::delete('/destroy/{id}', [\Modules\Order\Http\Controllers\Admin\OrderController::class, 'destroy']);

    // SHOW PRODUCT
    Route::get('/statics', [\Modules\Order\Http\Controllers\Admin\OrderController::class, 'statics']);
    Route::get('/show/{id}', [\Modules\Order\Http\Controllers\Admin\OrderController::class, 'show']);
    Route::get('/show-products/{id}', [\Modules\Order\Http\Controllers\Admin\OrderController::class, 'showProducts']);
    Route::get('/show-logs/{id}', [\Modules\Order\Http\Controllers\Admin\OrderController::class, 'showLogs']);
    Route::get('/show-sms-logs/{id}', [\Modules\Order\Http\Controllers\Admin\OrderController::class, 'showSmsLogs']);


    // UPDATE PRODUCT
    Route::post('/update/{id}', [\Modules\Order\Http\Controllers\Admin\OrderController::class, 'update']);
    Route::post('/update-bijak/{id}', [\Modules\Order\Http\Controllers\Admin\OrderController::class, 'updateBijak']);
    Route::post('/update-product-status/{id}', [\Modules\Order\Http\Controllers\Admin\OrderController::class, 'updateProductStatus']);

});



Route::group(['middleware' => ['auth:api'], 'prefix' => '/customer/orders'], function () {
    Route::get('/index', [\Modules\Order\Http\Controllers\Customer\OrderController::class, 'index']);
    Route::get('/show-products/{id}', [\Modules\Order\Http\Controllers\Customer\OrderController::class, 'showProducts']);
    Route::get('/statics', [\Modules\Order\Http\Controllers\Customer\OrderController::class, 'statics']);

    Route::post('/apply-coupon/{id}', [\Modules\Order\Http\Controllers\Customer\OrderController::class, 'applyCoupon']);
    Route::post('/set-address/{id}', [\Modules\Order\Http\Controllers\Customer\OrderController::class, 'setAddress']);
    Route::post('/set-delivery-type/{id}', [\Modules\Order\Http\Controllers\Customer\OrderController::class, 'setDeliveryType']);
    Route::post('/set-payment-type/{id}', [\Modules\Order\Http\Controllers\Customer\OrderController::class, 'setPaymentType']);
    Route::post('/set-bank-payment-details/{id}', [\Modules\Order\Http\Controllers\Customer\OrderController::class, 'setBankPaymentDetails']);
    Route::get('/{id}', [\Modules\Order\Http\Controllers\Customer\OrderController::class, 'show']);

});
