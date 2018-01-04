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

Route::get('/data/access-rules', 'DataController@accessRules');
Route::get('/data/group-access-rules', 'DataController@groupAccessRules');

Route::get('/locale', function () {
	echo App::getLocale();
});