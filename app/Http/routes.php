<?php

Route::get('/', 'Auth\AuthController@getLogin');
Route::controller('/auth', 'Auth\AuthController');

Route::group([
    'prefix' => '/admin'
], function () {
    Route::resource('/shop', 'ShopController');
    Route::resource('/category', 'CategoryController');
    Route::resource('/product', 'ProductController');
    Route::controller('/', 'DashboardController');
});
