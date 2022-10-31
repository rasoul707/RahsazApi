<?php


Route::group(['middleware' => [], 'prefix' => '/admin/reports'], function () {
    Route::get('/orders', [\Modules\Report\Http\Controllers\Admin\ReportController::class, 'orders']);
    Route::get('/customers', [\Modules\Report\Http\Controllers\Admin\ReportController::class, 'customers']);
    Route::get('customers/export', [\Modules\Report\Http\Controllers\Admin\ReportController::class, 'customersExport']);
    Route::get('/store-room', [\Modules\Report\Http\Controllers\Admin\ReportController::class, 'storeRoom']);
    Route::post('/store-room/update-property/{id}', [\Modules\Report\Http\Controllers\Admin\ReportController::class, 'storeRoomUpdateProperty']);
});

