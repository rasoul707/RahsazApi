<?php



Route::group(['middleware' => [], 'prefix' => '/admin/coupons'], function () {
    Route::get('/index', [\Modules\Coupon\Http\Controllers\Admin\CouponController::class, 'index']);
    Route::post('/store', [\Modules\Coupon\Http\Controllers\Admin\CouponController::class, 'store']);
    Route::put('/update/{id}', [\Modules\Coupon\Http\Controllers\Admin\CouponController::class, 'update']);
    Route::delete('/destroy/{id}', [\Modules\Coupon\Http\Controllers\Admin\CouponController::class, 'destroy']);
    Route::get('/show/{id}', [\Modules\Coupon\Http\Controllers\Admin\CouponController::class, 'show']);
});


