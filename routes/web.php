<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::get('test', function(){
    return view('email.beats-email');
});

Route::get('thanks', 'TransactionController@thanks');


Route::get('/info', 'TransactionController@info');
Route::get('/infonew', 'TransactionController@infonew');
Route::get('/zips/beats/{id}', 'TransactionController@download');

Route::get('/mail', function () {
    return view('mail');
});
Route::get('cron/delete', 'TransactionController@cron_delete_zip');
Route::post('/sendmail', 'AjaxController@sendmail');
Route::get('/', 'BeatController@index');

Auth::routes();

Route::get('login', 'Auth\LoginController@showLogin');
Route::get('/contact', 'ContactController@index');
Route::get('/faq', 'PageController@faq');
//Route::get('/dedicated/mobileapp', 'ContactController@dedicated_mobile');
Route::post('/contact', 'ContactController@store');

Route::post('payment', 'TransactionController@postPayment');
Route::get('payment/status', 'TransactionController@getPaymentStatus');
Route::get('/embed/player', 'Admin\ShopOptionController@embed_code');

Route::group(['prefix' => 'admin', 'middleware' => ['auth:web']], function () {

    Route::get('/', 'Admin\BeatController@index'); //temp route

    Route::get('/beats/', 'Admin\BeatController@index');
    Route::get('/beats/create/{id}', 'Admin\BeatController@create');
    Route::get('/beats/create', 'Admin\BeatController@create');
    Route::get('/beats/delete/{id}', 'Admin\BeatController@delete');
    Route::post('/beats', 'Admin\BeatController@store');
    Route::post('/beats/active/{id}', 'Admin\BeatController@active');
    Route::post('/beats/update', 'Admin\BeatController@update');
    Route::post('/beats/audio', 'Admin\BeatController@audio');

    Route::get('/banners', 'Admin\BannerController@index');
    Route::post('/banners', 'Admin\BannerController@update');
    Route::get('/banners/delete/{id}', 'Admin\BannerController@delete');

    Route::get('/categories', 'Admin\CategoryController@index');
    Route::post('/categories/active/{id}', 'Admin\CategoryController@active');
    Route::get('/categories/create', 'Admin\CategoryController@create');
    Route::get('/categories/edit/{id}', 'Admin\CategoryController@edit');
    Route::get('/categories/delete/{id}', 'Admin\CategoryController@delete');
    Route::post('/categories/update', 'Admin\CategoryController@update');
    Route::post('/categories/update/{id}', 'Admin\CategoryController@update');
    Route::post('/categories/create', 'Admin\CategoryController@store');

    Route::get('/pages', 'Admin\PageController@index');
    Route::get('/pages/create', 'Admin\PageController@create');
    Route::get('/pages/edit/{id}', 'Admin\PageController@edit');
    Route::get('/pages/delete/{id}', 'Admin\PageController@delete');
    Route::post('/pages/update', 'Admin\PageController@update');
    Route::post('/pages', 'Admin\PageController@store');
    Route::post('/pages/producer', 'Admin\PageController@producer_update');
    Route::post('/pages/faq', 'Admin\PageController@faqstore');
    Route::post('/pages/faq/update', 'Admin\PageController@faq_update');
    Route::post('/pages/img', 'Admin\PageController@image');
    Route::post('/pages/active/{id}', 'Admin\PageController@active');
    Route::post('/pages/faqs/active', 'Admin\PageController@faq_active');

    Route::get('/embed', 'Admin\ShopOptionController@embed');
    Route::post('/embed', 'Admin\ShopOptionController@store_embed');
    
    Route::get('/producers', 'Admin\ProducerController@index');
    Route::get('/producers/create', 'Admin\ProducerController@create');
    Route::get('/producers/edit/{id}', 'Admin\ProducerController@edit');
    Route::get('/producers/delete/{id}', 'Admin\ProducerController@delete');
    Route::post('/producers/update', 'Admin\ProducerController@update');
    Route::post('/producers/create', 'Admin\ProducerController@store');
    Route::post('/producers/active/{id}', 'Admin\ProducerController@active');
    
    Route::get('/sounds_like', 'Admin\SoundLikeController@index');
    Route::get('/sounds_like/create', 'Admin\SoundLikeController@create');
    Route::get('/sounds_like/edit/{id}', 'Admin\SoundLikeController@edit');
    Route::get('/sounds_like/delete/{id}', 'Admin\SoundLikeController@delete');
    Route::post('/sounds_like/update', 'Admin\SoundLikeController@update');
    Route::post('/sounds_like/create', 'Admin\SoundLikeController@store');
    Route::post('/sounds_like/active/{id}', 'Admin\SoundLikeController@active');

    Route::get('/shop_options', 'Admin\ShopOptionController@index');
    Route::get('/shop_options/paypal', 'Admin\ShopOptionController@index');
    Route::post('/shop_options/create', 'Admin\ShopOptionController@store');
    Route::post('/shop_options/resetfields', 'Admin\ShopOptionController@reset_fields');

    Route::get('/stats', 'Admin\StatsController@index');

});
    Route::post('/password/forgot', 'Auth\LoginController@forgot_password');
    Route::get('/{slug}', 'PageController@index');



