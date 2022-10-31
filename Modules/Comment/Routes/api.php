<?php

Route::group(['middleware' => [], 'prefix' => '/admin/comments'], function () {
    Route::get('/index', [\Modules\Comment\Http\Controllers\Admin\CommentController::class, 'index']);
    Route::get('/show/{id}', [\Modules\Comment\Http\Controllers\Admin\CommentController::class, 'show']);
    Route::delete('/destroy/{id}', [\Modules\Comment\Http\Controllers\Admin\CommentController::class, 'destroy']);
    Route::put('/toggle-active/{id}', [\Modules\Comment\Http\Controllers\Admin\CommentController::class, 'toggleActive']);
    Route::post('/response/{id}', [\Modules\Comment\Http\Controllers\Admin\CommentController::class, 'response']);
});

