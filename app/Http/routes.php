<?php

Route::get('/', 'Auth\AuthController@getLogin');
Route::controller('/auth', 'Auth\AuthController');
