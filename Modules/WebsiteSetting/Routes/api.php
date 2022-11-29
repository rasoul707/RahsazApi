<?php


Route::group(['middleware' => [], 'prefix' => '/admin/website-setting'], function () {
    Route::post('/setup', [\Modules\WebsiteSetting\Http\Controllers\Admin\WebsiteSettingController::class, 'setup']);
    Route::post('/homepage-groups/setup', [\Modules\WebsiteSetting\Http\Controllers\Admin\WebsiteSettingController::class, 'homepageGroupsSetup']);


    Route::get('/index', [\Modules\WebsiteSetting\Http\Controllers\Admin\WebsiteSettingController::class, 'index']);

    // SLIDERS
    Route::get('/sliders/index', [\Modules\WebsiteSetting\Http\Controllers\Admin\SliderController::class, 'index']);
    Route::get('/sliders/show/{id}', [\Modules\WebsiteSetting\Http\Controllers\Admin\SliderController::class, 'show']);
    Route::delete('/sliders/destroy/{id}', [\Modules\WebsiteSetting\Http\Controllers\Admin\SliderController::class, 'destroy']);
    Route::put('/sliders/update/{id}', [\Modules\WebsiteSetting\Http\Controllers\Admin\SliderController::class, 'update']);
    Route::post('/sliders/store', [\Modules\WebsiteSetting\Http\Controllers\Admin\SliderController::class, 'store']);

    //HOMEPAGE GROUPS
    Route::get('/homepage-groups/index', [\Modules\WebsiteSetting\Http\Controllers\Admin\HomepageGroupController::class, 'index']);
    Route::get('/homepage-groups/show/{id}', [\Modules\WebsiteSetting\Http\Controllers\Admin\HomepageGroupController::class, 'show']);
    Route::put('/homepage-groups/update-title/{id}', [\Modules\WebsiteSetting\Http\Controllers\Admin\HomepageGroupController::class, 'updateTitle']);
    Route::put('/homepage-groups/update-status/{id}', [\Modules\WebsiteSetting\Http\Controllers\Admin\HomepageGroupController::class, 'updateStatus']);
    Route::put('/homepage-groups/add-product/{id}', [\Modules\WebsiteSetting\Http\Controllers\Admin\HomepageGroupController::class, 'addProduct']);
    Route::put('/homepage-groups/delete-product/{id}', [\Modules\WebsiteSetting\Http\Controllers\Admin\HomepageGroupController::class, 'deleteProduct']);
    Route::put('/homepage-groups/reset/{id}', [\Modules\WebsiteSetting\Http\Controllers\Admin\HomepageGroupController::class, 'reset']);


    // BANNERS
    Route::post('/banners/store', [\Modules\WebsiteSetting\Http\Controllers\Admin\BannerController::class, 'store']);
    Route::get('/banners/index', [\Modules\WebsiteSetting\Http\Controllers\Admin\BannerController::class, 'index']);


    // FooterSettings
    Route::get('/footer/index', [\Modules\WebsiteSetting\Http\Controllers\Admin\FooterController::class, 'index']);
    Route::get('/footer/show/{id}', [\Modules\WebsiteSetting\Http\Controllers\Admin\FooterController::class, 'show']);
    Route::post('/footer/store', [\Modules\WebsiteSetting\Http\Controllers\Admin\FooterController::class, 'store']);
    Route::post('/footer/store/item', [\Modules\WebsiteSetting\Http\Controllers\Admin\FooterController::class, 'storeItem']);
    Route::delete('/footer/destroy/item/{id}', [\Modules\WebsiteSetting\Http\Controllers\Admin\FooterController::class, 'destroyItem']);
    Route::delete('/footer/destroy/{id}', [\Modules\WebsiteSetting\Http\Controllers\Admin\FooterController::class, 'destroy']);
    Route::post('/footer/update/{id}', [\Modules\WebsiteSetting\Http\Controllers\Admin\FooterController::class, 'update']);
});



Route::group(['middleware' => [], 'prefix' => '/website-setting'], function () {
    Route::get('/index', [\Modules\WebsiteSetting\Http\Controllers\WebsiteSettingController::class, 'index']);
});



Route::group(['middleware' => [], 'prefix' => '/admin/general-setting'], function () {
    Route::put('/currencies/setup/{id}', [\Modules\WebsiteSetting\Http\Controllers\Admin\GeneralSettingController::class, 'currenciesSetup']);
    Route::get('/currencies/index', [\Modules\WebsiteSetting\Http\Controllers\Admin\GeneralSettingController::class, 'currenciesIndex']);

    Route::post('/tax-and-rounding/setup', [\Modules\WebsiteSetting\Http\Controllers\Admin\GeneralSettingController::class, 'taxAndRoundingSetup']);
    Route::get('/tax-and-rounding/index', [\Modules\WebsiteSetting\Http\Controllers\Admin\GeneralSettingController::class, 'taxAndRoundingIndex']);

    Route::post('/signup-forms/setup', [\Modules\WebsiteSetting\Http\Controllers\Admin\GeneralSettingController::class, 'signupFormsSetup']);
    Route::get('/signup-forms/index', [\Modules\WebsiteSetting\Http\Controllers\Admin\GeneralSettingController::class, 'signupFormsIndex']);

    Route::post('/company-info/setup', [\Modules\WebsiteSetting\Http\Controllers\Admin\GeneralSettingController::class, 'companyInfoSetup']);
    Route::get('/company-info/index', [\Modules\WebsiteSetting\Http\Controllers\Admin\GeneralSettingController::class, 'companyInfoIndex']);
});



Route::group(['middleware' => [], 'prefix' => '/general-setting'], function () {
    Route::get('/signup-forms/index', [\Modules\WebsiteSetting\Http\Controllers\WebsiteSettingController::class, 'signupFormsIndex']);
});
