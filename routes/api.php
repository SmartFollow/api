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

Route::get('/user', function (Request $request) {
	return App\Models\Users\User::with('group')
								->with('group.accessRules')
								->findOrFail($request->user()->id);
})->middleware('auth:api');

Route::group(['middleware' => ['auth:api']], function()
{
	Route::resource('groups', 'GroupController');
	Route::get('/groups/{id}/access-rules', ['as' => 'groups.show.access-rules', 'uses' => 'GroupController@showAccessRules'])
		->where(['id' => '[0-9]+']);
});
