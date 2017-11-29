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
		$lesson = Lesson::with('studentClass.students')
						->with('evaluations')
						->findOrFail($lessonId);

		$criteria = Criterion::get();

		return [
			'students' => $lesson->studentClass->students,
			'existing_evaluations' => $lesson->evaluations,
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
	    $this->validate($request, [
		    'comment' => 'required',
	    ]);

	    $evaluation = Evaluation::findOrFail($id);
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

		$evaluation->delete();
    }
}
