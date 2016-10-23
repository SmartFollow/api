<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

Route::get('users/{id}/show', 'UsersController@show');
Route::get('users/{id}/update', 'UsersController@update');
Route::get('users/{id}/destroy', 'UsersController@destroy');
Route::resource('users', 'UsersController');