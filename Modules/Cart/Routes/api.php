<?php


Route::group(['middleware' => ['auth:api'], 'prefix' => '/customer/cart'], function () {
    Route::get('/', [\Modules\Cart\Http\Controllers\Customer\CartController::class, 'index']);
    Route::post('/add-product', [\Modules\Cart\Http\Controllers\Customer\CartController::class, 'addProduct']);
    Route::post('/delete-product', [\Modules\Cart\Http\Controllers\Customer\CartController::class, 'deleteProduct']);
    Route::put('/empty', [\Modules\Cart\Http\Controllers\Customer\CartController::class, 'emptyCart']);
    Route::post('/finalize', [\Modules\Cart\Http\Controllers\Customer\CartController::class, 'finalize']);
});
