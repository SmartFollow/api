<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pedagogy\Lesson;
use App\Models\Pedagogy\Exams\Exam;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function createLessonExam($lessonId)
    {
        $lesson = Lesson::with('documents')->findOrFail($lessonId);

		return [
			'lesson' => $lesson,
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
        //
    }

    public function storeLessonExam(Request $request, $lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);

        $this->validate($request, [
			'type' => 'required|in:home,class,surprise',
			'description' => '',
			'min_mark' => 'numeric',
			'max_mark' => 'numeric',
		]);

		$exam = new Exam();
		$exam->lesson_id = $lesson->id;
		$exam->type = $request->get('type');
		if ($request->has('description'))
			$exam->description = $request->get('description');
		if ($request->has('min_mark'))
			$exam->min_mark = $request->get('min_mark');
		if ($request->has('max_mark'))
			$exam->max_mark = $request->get('max_mark');
		$exam->save();

		return $exam;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$exam = Exam::with('lesson')->findOrFail($id);

		return $exam;
    }

	public function showLessonExam($lessonId)
	{
		$examId = Lesson::findOrFail($lessonId)->exam_id;

		return $this->show($examId);
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);

		$exam->delete();
    }
}
