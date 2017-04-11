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
	Route::group(['prefix' => '/users'], function()
	{
		Route::put('/change-password', ['as' => 'users.change-password', 'uses' => 'UsersController@changePassword']);
		Route::get('/profile/access-rules', ['as' => 'users.profile.access-rules', 'uses' => 'UserController@profileAccessRules']);
		Route::get('/profile', ['as' => 'users.profile', 'uses' => 'UserController@profile']);
	});
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
	 * Routes related to rooms
	 */
	Route::group(['prefix' => '/rooms'], function()
	{

	});
	Route::resource('rooms', 'RoomController');

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
		Route::get('/history', ['as' => 'lessons.history', 'uses' => 'LessonController@lessonHistory']);

		Route::group(['prefix' => '/{lessonId}'], function()
		{
			Route::resource('homeworks', 'HomeworkController');

			Route::group(['prefix' => '/exam'], function()
			{
				Route::get('/', ['as' => 'lessons.exams.show', 'uses' => 'ExamController@showLessonExam']);
				Route::get('/create', ['as' => 'lessons.exams.create', 'uses' => 'ExamController@createLessonExam']);
				Route::post('/', ['as' => 'lessons.exams.store', 'uses' => 'ExamController@storeLessonExam']);
			});

			Route::post('/documents', ['as' => 'lessons.documents.store', 'uses' => 'DocumentController@storeLessonDocument']);
			Route::get('/documents/{id}', ['as' => 'lessons.documents.show', 'uses' => 'DocumentController@showLessonDocument'])
				 ->where(['id' => '[0-9]+']);

			Route::group(['prefix' => 'evaluations'], function()
			{
				Route::get('/', 'EvaluationController@indexLessonEvaluations');
				Route::get('/create', 'EvaluationController@createLessonEvaluations');
			});
		});
	});
	Route::resource('lessons', 'LessonController');

	Route::group(['prefix' => '/exams'], function()
	{
		Route::group(['prefix' => '/{examId}'], function()
		{
			Route::resource('marks', 'MarkController');
		});
	});
	Route::resource('exams', 'ExamController');

	Route::group(['prefix' => '/documents'], function()
	{

	});
	Route::resource('documents', 'DocumentController');

	/**
	 * Routes related to the reservations
	 */
	Route::group(['prefix' => '/reservations'], function()
	{

	});
	Route::resource('reservations', 'ReservationController');

	/**
	 * Routes related to the evaluations
	 */
	Route::group(['prefix' => '/evaluations'], function()
	{
		Route::group(['prefix' => '/{evaluationId}'], function()
		{
			Route::resource('absences', 'AbsenceController');
			Route::resource('delays', 'DelayController', ['only' => ['destroy', 'store']]);

			Route::resource('criteria', 'CriterionEvaluationController', ['except' => ['show', 'destroy']]);
		});
	});
	Route::resource('evaluations', 'EvaluationController');

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
