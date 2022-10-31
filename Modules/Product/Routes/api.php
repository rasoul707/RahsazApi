<?php


Route::group(['middleware' => [], 'prefix' => '/admin/products'], function () {
    Route::post('/store', [\Modules\Product\Http\Controllers\Admin\ProductController::class, 'store']);
    Route::get('/index', [\Modules\Product\Http\Controllers\Admin\ProductController::class, 'index']);
    Route::get('/show/{id}', [\Modules\Product\Http\Controllers\Admin\ProductController::class, 'show']);
    Route::put('/update/{id}', [\Modules\Product\Http\Controllers\Admin\ProductController::class, 'update']);
    Route::delete('/destroy/{id}', [\Modules\Product\Http\Controllers\Admin\ProductController::class, 'destroy']);
    Route::get('/label-search', [\Modules\Product\Http\Controllers\Admin\ProductController::class, 'labelSearch']);
    Route::get('/categories', [\Modules\Product\Http\Controllers\Admin\ProductController::class, 'showCategories']);
    Route::get('/sub-category/label-search', [\Modules\Product\Http\Controllers\Admin\ProductController::class, 'subCategoryLabelSearch']);
});


Route::group(['middleware' => [], 'prefix' => '/products'], function () {
    Route::get('/index', [\Modules\Product\Http\Controllers\ProductController::class, 'index']);
    Route::get('/show/{id}', [\Modules\Product\Http\Controllers\ProductController::class, 'show']);
    Route::get('/categories', [\Modules\Product\Http\Controllers\ProductController::class, 'showCategories']);
    Route::post('/send-review/{id}', [\Modules\Product\Http\Controllers\ProductController::class, 'sendReview']);
    Route::post('/alert/{id}', [\Modules\Product\Http\Controllers\ProductController::class, 'alert'])->middleware('auth:api');
    Route::post('/rating', [\Modules\Product\Http\Controllers\RatingController::class, 'store'])->middleware('auth:api');
});
