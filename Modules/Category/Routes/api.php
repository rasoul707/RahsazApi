<?php

Route::group(['middleware' => [], 'prefix' => '/admin/categories'], function () {
    Route::get('/update-order-item/{param}', [\Modules\Category\Http\Controllers\Admin\CategoryController::class, 'updateOrderItem']);
    Route::get('/fathers-index', [\Modules\Category\Http\Controllers\Admin\CategoryController::class, 'fathersIndex']);
    Route::get('/child/{id}/items', [\Modules\Category\Http\Controllers\Admin\CategoryController::class, 'childItems']);
    Route::get('/{id}/children-names', [\Modules\Category\Http\Controllers\Admin\CategoryController::class, 'childrenNames']);
    Route::get('/{id}/label-search', [\Modules\Category\Http\Controllers\Admin\CategoryController::class, 'labelSearch']);
    Route::put('/rename-children', [\Modules\Category\Http\Controllers\Admin\CategoryController::class, 'renameChildren']);
    Route::put('/reorder-children', [\Modules\Category\Http\Controllers\Admin\CategoryController::class, 'reorderChildren']);
    Route::post('/store-item', [\Modules\Category\Http\Controllers\Admin\CategoryController::class, 'storeItem']);
    Route::get('/show-item/{id}', [\Modules\Category\Http\Controllers\Admin\CategoryController::class, 'showItem']);
    Route::put('/update-item/{id}', [\Modules\Category\Http\Controllers\Admin\CategoryController::class, 'updateItem']);
    Route::delete('/destroy-item/{id}', [\Modules\Category\Http\Controllers\Admin\CategoryController::class, 'destroyItem']);
    Route::put('/reorder-items', [\Modules\Category\Http\Controllers\Admin\CategoryController::class, 'reorderItems']);
    Route::get('/item/{id}/products', [\Modules\Category\Http\Controllers\Admin\CategoryController::class, 'itemProducts']);
    Route::post('/item/{id}/store-product', [\Modules\Category\Http\Controllers\Admin\CategoryController::class, 'storeItemProduct']);
    Route::post('/item/{id}/store-image', [\Modules\Category\Http\Controllers\Admin\CategoryController::class, 'storeItemImage']);
    Route::post('/item/{id}/destroy-product', [\Modules\Category\Http\Controllers\Admin\CategoryController::class, 'destroyItemProduct']);
    Route::post('/updateMenu', [\Modules\Category\Http\Controllers\Admin\CategoryController::class, 'updateMenu']);
});



Route::group(['prefix' => '/categories'], function () {
    Route::get('/navbar', [\Modules\Category\Http\Controllers\CategoryController::class, 'navbar']);
});
