<?php
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

Route::group(['middleware' => ['auth:api']], function()
{

	Route::resource('groups', 'GroupController');
	Route::get('/groups/{id}/access-rules', ['as' => 'groups.show.access-rules', 'uses' => 'GroupController@showAccessRules'])
		->where(['id' => '[0-9]+']);

	Route::resource('users', 'UsersController');

	Route::group(['prefix' => 'processes'], function()
	{

	});
	Route::resource('processes', 'ProcessController');

	Route::group(['prefix' => 'steps'], function()
	{

	});
	Route::resource('steps', 'StepController');

	Route::group(['prefix' => 'conversations'], function()
	{

	});
	Route::resource('conversations', 'ConversationController');
	Route::resource('messages', 'MessageController', ['only' => ['store']]);
});
