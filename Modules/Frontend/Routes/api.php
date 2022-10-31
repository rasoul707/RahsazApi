<?php

Route::group(['prefix' => '/frontend'], function () {
    Route::get('/homepage', [\Modules\Frontend\Http\Controllers\FrontendController::class, 'homepage']);
    Route::get('/about-us', [\Modules\Frontend\Http\Controllers\FrontendController::class, 'aboutUs']);
    Route::get('/mega-menu', [\Modules\Frontend\Http\Controllers\FrontendController::class, 'megaMenu']);
    Route::get('/map-mega-menu', [\Modules\Frontend\Http\Controllers\FrontendController::class, 'mapMegaMenu']);
    Route::get('/map', [\Modules\Frontend\Http\Controllers\FrontendController::class, 'map']);
});

