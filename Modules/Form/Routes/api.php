<?php


Route::group(['prefix' => '/forms'], function () {
    Route::post('/store', [\Modules\Form\Http\Controllers\FormController::class, 'store']);
});

Route::group(['prefix' => '/admin/forms'], function () {
    Route::get('/index', [\Modules\Form\Http\Controllers\Admin\FormController::class, 'index']);
    Route::get('/show/{id}', [\Modules\Form\Http\Controllers\Admin\FormController::class, 'show']);
    Route::delete('/destroy/{id}', [\Modules\Form\Http\Controllers\Admin\FormController::class, 'destroy']);

    // TODO : event o listener vaghti store mishe email bere be admin + response payamak o internal message
});
