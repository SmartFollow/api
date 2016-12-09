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

/**
 * Route group for the routes requiring authentication
 */
Route::group(['middleware' => ['auth:api']], function()
{

	/**
	 * Routes related to the users
	 */
	Route::resource('users', 'UserController');

	/**
	 * Routes related to the groups
	 */
	Route::group(['prefix' => '/groups'], function()
	{
		Route::get('/{id}/access-rules', ['as' => 'groups.show.access-rules', 'uses' => 'GroupController@showAccessRules'])
			->where(['id' => '[0-9]+']);
	});
	Route::resource('groups', 'GroupController');


	/**
	 * Routes related to the levels
	 */
	Route::group(['prefix' => '/levels'], function()
	{
		Route::post('/{id}/student-classes', ['as' => 'levels.student-classes.store', 'uses' => 'LevelController@addStudentClasses'])
			->where(['id' => '[0-9]+']);
		Route::get('/{id}/student-classes', ['as' => 'levels.student-classes.index', 'uses' => 'LevelController@listStudentClasses'])
			->where(['id' => '[0-9]+']);

		Route::get('/{id}/subjects', ['as' => 'levels.subjects.index', 'uses' => 'LevelController@listSubjects'])
			->where(['id' => '[0-9]+']);
	});
	Route::resource('levels', 'LevelController');

	/**
	 * Routes related to the subjects
	 */
	Route::group(['prefix' => '/subjects'], function()
	{
		Route::get('/{id}/student-classes', ['as' => 'subjects.student-classes.index', 'uses' => 'SubjectController@listStudentClasses'])
			->where(['id' => '[0-9]+']);
	});
	Route::resource('subjects', 'SubjectController');

	/**
	 * Routes related to the student classes
	 */
	Route::group(['prefix' => '/student-classes'], function()
	{
		Route::put('/{id}/students', ['as' => 'student-classes.students.update', 'uses' => 'StudentClassController@updateStudents'])
			->where(['id' => '[0-9]+']);
		Route::get('/{id}/students', ['as' => 'student-classes.students.index', 'uses' => 'StudentClassController@listStudents'])
			->where(['id' => '[0-9]+']);

		Route::put('/{id}/subjects', ['as' => 'student-classes.subjects.update', 'uses' => 'StudentClassController@updateSubjects'])
			->where(['id' => '[0-9]+']);
		Route::get('/{id}/subjects', ['as' => 'student-classes.subjects.index', 'uses' => 'StudentClassController@listSubjects'])
			->where(['id' => '[0-9]+']);
	});
	Route::resource('student-classes', 'StudentClassController');

	/**
	 * Routes related to the lessons
	 */
	Route::group(['prefix' => '/lessons'], function()
	{

	});
	Route::resource('lessons', 'LessonController');

	/**
	 * Routes related to the reservations
	 */
	Route::group(['prefix' => '/reservations'], function()
	{

	});
	Route::resource('reservations', 'ReservationController');

});
