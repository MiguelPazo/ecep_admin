<?php

Route::get('/', 'Auth\AuthController@getLogin');
Route::controller('/auth', 'Auth\AuthController');
Route::get('/end-point/gemalto-auth-if', function () {
    return view('dashboard-if');
});
Route::get('/end-point/gemalto-auth-hf', function () {
    abort(401);
});
Route::controller('/end-point', 'Auth\EndpointController');


Route::group([
    'middleware' => 'auth',
    'prefix' => '/admin',
], function () {
    Route::controller('/', 'DashboardController');
});
