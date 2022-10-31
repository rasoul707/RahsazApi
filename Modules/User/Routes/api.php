<?php
Route::post('/rss', [\Modules\User\Http\Controllers\AuthController::class, 'rss']);

Route::post('/logout', [\Modules\User\Http\Controllers\AuthController::class, 'logout'])->middleware(['auth:api']);

Route::post('/login-via-email', [\Modules\User\Http\Controllers\AuthController::class, 'loginViaEmail']);
Route::post('/login-via-phone', [\Modules\User\Http\Controllers\AuthController::class, 'loginViaPhone']);

Route::post('/login-via-otp', [\Modules\User\Http\Controllers\AuthController::class, 'loginViaOTP']);
Route::post('/login/otp/send-otp-code', [\Modules\User\Http\Controllers\AuthController::class, 'sendOTPCode']);

/* Forgot password*/
Route::post('/forgot-password/send-new-password', [\Modules\User\Http\Controllers\AuthController::class, 'forgotPasswordSendNewPassword']);


Route::post('/register', [\Modules\User\Http\Controllers\AuthController::class, 'register']);
Route::post('/register/send-verification-code', [\Modules\User\Http\Controllers\AuthController::class, 'sendVerificationCode'])->middleware( 'throttle:3,10');
Route::post('/register/verify-phone', [\Modules\User\Http\Controllers\AuthController::class, 'verifyPhone']);


Route::group(['middleware' => [], 'prefix' => '/admin/customers'], function () {
    Route::get('/index', [\Modules\User\Http\Controllers\Admin\CustomerController::class, 'index']);
    Route::get('/show/{id}', [\Modules\User\Http\Controllers\Admin\CustomerController::class, 'show']);
    Route::put('/update/{id}', [\Modules\User\Http\Controllers\Admin\CustomerController::class, 'update']);
    Route::post('/store', [\Modules\User\Http\Controllers\Admin\CustomerController::class, 'store']);
    Route::delete('/destroy/{id}', [\Modules\User\Http\Controllers\Admin\CustomerController::class, 'destroy']);
    Route::get('/label-search', [\Modules\User\Http\Controllers\Admin\CustomerController::class, 'labelSearch']);
    Route::get('/packages/label-search', [\Modules\User\Http\Controllers\Admin\CustomerController::class, 'packagesLabelSearch']);
    Route::get('/addresses/{id}', [\Modules\User\Http\Controllers\Admin\CustomerController::class, 'addresses']);
});



Route::group(['middleware' => [], 'prefix' => '/admin/sub-admins'], function () {
    Route::get('/index', [\Modules\User\Http\Controllers\Admin\SubAdminController::class, 'index']);
    Route::get('/show/{id}', [\Modules\User\Http\Controllers\Admin\SubAdminController::class, 'show']);
    Route::get('/show-permissions/', [\Modules\User\Http\Controllers\Admin\SubAdminController::class, 'showPermissions']);
    Route::put('/update/{id}', [\Modules\User\Http\Controllers\Admin\SubAdminController::class, 'update']);
    Route::put('/update-permissions/{id}', [\Modules\User\Http\Controllers\Admin\SubAdminController::class, 'updatePermissions']);
    Route::delete('/destroy/{id}', [\Modules\User\Http\Controllers\Admin\SubAdminController::class, 'destroy']);
    Route::post('/store', [\Modules\User\Http\Controllers\Admin\SubAdminController::class, 'store']);
    Route::get('/label-search', [\Modules\User\Http\Controllers\Admin\SubAdminController::class, 'labelSearch']);
});

Route::group(['middleware' => ['auth:api'], 'prefix' => '/customer'], function () {
    Route::post('/upload-image', [\Modules\User\Http\Controllers\Customer\ProfileController::class, 'uploadImage']);
});


Route::group(['middleware' => ['auth:api'], 'prefix' => '/customer/profile'], function () {
    Route::get('/show', [\Modules\User\Http\Controllers\Customer\ProfileController::class, 'show']);
    Route::put('/update', [\Modules\User\Http\Controllers\Customer\ProfileController::class, 'updateProfile']);
    Route::put('/update-password', [\Modules\User\Http\Controllers\Customer\ProfileController::class, 'updatePassword']);
});


Route::group(['middleware' => ['auth:api'], 'prefix' => '/customer/addresses'], function () {
    Route::get('/index', [\Modules\User\Http\Controllers\Customer\AddressController::class, 'index']);
    Route::put('/update/{id}', [\Modules\User\Http\Controllers\Customer\AddressController::class, 'update']);
    Route::post('/store', [\Modules\User\Http\Controllers\Customer\AddressController::class, 'store']);
});

Route::group(['middleware' => ['auth:api'], 'prefix' => '/customer/coupons'], function () {
    Route::get('/index', [\Modules\User\Http\Controllers\Customer\CouponController::class, 'index']);
});

Route::group(['middleware' => ['auth:api'], 'prefix' => '/customer/internal-messages'], function () {
    Route::get('/index', [\Modules\User\Http\Controllers\Customer\InternalMessageController::class, 'index']);
});



Route::group(['middleware' => ['auth:api'], 'prefix' => '/customer/comments'], function () {
    Route::get('/index', [\Modules\User\Http\Controllers\Customer\CommentController::class, 'index']);
});



Route::group(['middleware' => ['auth:api'], 'prefix' => '/customer/product-visits'], function () {
    Route::get('/index', [\Modules\User\Http\Controllers\Customer\ProductVisitController::class, 'index']);
});
