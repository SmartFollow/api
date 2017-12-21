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
	/*
	 * Routes related to the users
	 */
	Route::group(['prefix' => '/users'], function()
	{
		Route::get('/profile/access-rules', ['as' => 'users.profile.access-rules', 'uses' => 'UserController@profileAccessRules']);
		Route::get('/profile', ['as' => 'users.profile', 'uses' => 'UserController@profile']);

		Route::put('/profile/password', ['as' => 'users.profile.update-password', 'uses' => 'UserController@updateProfilePassword']);
		Route::put('/{user}/password', ['as' => 'users.show.update-password', 'uses' => 'UserController@updateUserPassword'])
			 ->where(['user' => '[0-9]+']);

		Route::post('/profile/avatar', ['as' => 'users.profile.update-avatar' ,'uses' => 'UserController@updateProfileAvatar']);
		Route::post('/{user}/avatar', ['as' => 'users.show.update-avatar' ,'uses' => 'UserController@updateUserAvatar'])
			 ->where(['user' => '[0-9]+']);

		Route::get('/profile/processes', 'ProcessUserController@profileProcesses');
		Route::get('/{user}/processes', 'ProcessUserController@userProcesses');
		Route::delete('/{user}/processes/{process}', 'ProcessUserController@destroy');

		Route::get('/profile/graphs', 'GraphController@profileGraphs');
		Route::get('/{user}/graphs', 'GraphController@userGraphs');
	});
	Route::resource('users', 'UserController');

	/*
	 * Routes related to the groups
	 */
	Route::group(['prefix' => '/groups'], function()
	{
		Route::get('/{id}/access-rules', ['as' => 'groups.show.access-rules', 'uses' => 'GroupController@showAccessRules'])
			 ->where(['id' => '[0-9]+']);
	});
	Route::resource('groups', 'GroupController');

	/*
	 * Routes related to rooms
	 */
	Route::group(['prefix' => '/rooms'], function()
	{

	});
	Route::resource('rooms', 'RoomController');

	/*
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

	/*
	 * Routes related to the subjects
	 */
	Route::group(['prefix' => '/subjects'], function()
	{
		Route::get('/{id}/student-classes', ['as' => 'subjects.student-classes.index', 'uses' => 'SubjectController@listStudentClasses'])
			->where(['id' => '[0-9]+']);
	});
	Route::resource('subjects', 'SubjectController');

	/*
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

	/*
	 * Routes related to the lessons
	 */
	Route::group(['prefix' => '/lessons'], function()
	{
		Route::get('/history', ['as' => 'lessons.history', 'uses' => 'LessonController@history']);

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
				Route::get('/', 'EvaluationController@indexLessonEvaluations')->name('lessons.evaluations.index');
				Route::get('/create', 'EvaluationController@createLessonEvaluations')->name('lessons.evaluations.create');
			});
		});
	});
	Route::resource('lessons', 'LessonController');

	/*
	 * Routes related to the exams
	 */
	Route::group(['prefix' => '/exams'], function()
	{
		Route::group(['prefix' => '/{examId}'], function()
		{
			Route::resource('marks', 'MarkController');
		});
	});
	Route::resource('exams', 'ExamController');

	/*
	 * Routes related to the documents
	 */
	Route::group(['prefix' => '/documents'], function()
	{

	});
	Route::resource('documents', 'DocumentController');

	/*
	 * Routes related to the reservations
	 */
	Route::group(['prefix' => '/reservations'], function()
	{

	});
	Route::resource('reservations', 'ReservationController');

	/*
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
	Route::resource('absences', 'AbsenceController', ['only' => ['index', 'update']]);

	/**
	 * Routes related to the notifications
	 */
	Route::group(['prefix' => '/notifications'], function()
	{
		Route::put('/{id}/read','NotificationController@markAsRead')->name('notifications.mark-as-read');
	});
	Route::resource('notifications', 'NotificationController');

	/*
	 * Routes related to the processes
	 */
	Route::group(['prefix' => 'processes'], function()
	{

	});
	Route::group(['prefix' => 'processes-users'], function ()
	{
		Route::post('/', 'ProcessUserController@store');
		Route::put('/', 'ProcessUserController@update');
	});
	Route::resource('processes', 'ProcessController');

	/*
	 * Routes related to the steps
	 */
	Route::group(['prefix' => 'steps'], function()
	{

	});
	Route::resource('steps', 'StepController');

	/*
	 * Routes related to the conversations and messages
	 */
	Route::group(['prefix' => 'conversations'], function()
	{

	});
	Route::resource('conversations', 'ConversationController');
	Route::resource('messages', 'MessageController', ['only' => ['store']]);

	Route::resource('graphs', 'GraphController');

	Route::resource('criteria', 'CriterionController');

	Route::resource('difficulties', 'DifficultyController', ['only' => ['index']]);

	Route::resource('alerts', 'AlertController', ['only' => ['index']]);

	/*
	 * Routes used to manually launch AI related systems
	 */
	Route::group(['prefix' => 'ai'], function()
	{
		Route::group(['prefix' => 'students'], function() {
			Route::get('sum', 'AIController@criteriaStudentsSum');
			Route::get('average', 'AIController@criteriaStudentsAverage');
			Route::get('absence-delay', 'AIController@absenceDelaysStudents');
		});

		Route::group(['prefix' => 'classes'], function() {
			Route::get('sum', 'AIController@criteriaClassesSum');
			Route::get('average', 'AIController@criteriaClassesAverage');
			Route::get('absence-delay', 'AIController@absenceDelaysClasses');
		});

		Route::group(['prefix' => 'given'], function() {
			Route::get('sum', 'AIController@criteriaGivenSum');
			Route::get('average', 'AIController@criteriaGivenAverage');
			Route::get('absence-delay', 'AIController@absenceDelaysGiven');
		});
	});
});
