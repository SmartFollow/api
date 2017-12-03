<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pedagogy\Evaluations\Evaluation;
use App\Models\Pedagogy\Lesson;
use App\Models\Pedagogy\Evaluations\Criterion;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$this->authorize('index', Evaluation::class);

        $evaluations = Evaluation::get();

        $evaluations->load('criteria');
        $evaluations->load('lesson.subject.teacher');
        $evaluations->load('student');

        return $evaluations;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexLessonEvaluations($lessonId)
    {
	    $this->authorize('index', Evaluation::class);

		$evaluations = Evaluation::whereHas('lesson', function ($q) use ($lessonId) {
			$q->where('lessons.id', $lessonId);
		})->get();

		return $evaluations;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createLessonEvaluations($lessonId)
    {
	    $this->authorize('store', Evaluation::class);

	    /*
		$lesson = Lesson::with('studentClass.students')
						->with('evaluations')
						->findOrFail($lessonId);

		foreach ($lesson->studentClass->students as &$student)
		{
			$student->load(['evaluations' => function ($q) use ($lessonId) {
				$q->where('lesson_id', $lessonId);
			}]);
		}
	    */

		$criteria = Criterion::get();

		return [
			// 'students' => $lesson->studentClass->students,
			// 'existing_evaluations' => $lesson->evaluations,
			'criteria' => $criteria,
		];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $this->authorize('store', Evaluation::class);

		$this->validate($request, [
			'student_id' => 'exists:users,id|required',
			'lesson_id' => 'exists:lessons,id|required',
			'comment' => '',
		]);

        $lesson = Lesson::findOrFail($request->get('lesson_id'));

		// Verify if student is enrolled in class

		$evaluation = new Evaluation();
		$evaluation->lesson_id = $request->get('lesson_id');
		$evaluation->student_id = $request->get('student_id');
		if ($request->has('comment'))
			$evaluation->comment = $request->get('comment');
		$evaluation->save();

		return $evaluation;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $evaluation = Evaluation::with('lesson')
								->with('criteria')
								->with('student')
								->findOrFail($id);

	    $this->authorize('show', $evaluation);

		return $evaluation;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    $evaluation = Evaluation::findOrFail($id);

	    $this->authorize('update', $evaluation);

	    return $evaluation;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
	    $evaluation = Evaluation::findOrFail($id);

	    $this->authorize('update', $evaluation);

	    $this->validate($request, [
		    'comment' => 'required',
	    ]);

	    $evaluation->comment = $request->comment;
	    $evaluation->save();

	    return $evaluation;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$evaluation = Evaluation::findOrFail($id);

	    $this->authorize('destroy', $evaluation);

		$evaluation->delete();
    }
}
