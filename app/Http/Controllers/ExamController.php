<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    }

	/**
     * Show the form for creating a new resource on a lesson.
     *
     * @return \Illuminate\Http\Response
     */
    public function createLessonExam($lessonId)
    {
    	$this->authorize('store', Exam::class);

        $lesson = Lesson::with('documents')
						->findOrFail($lessonId);

		return [
			'lesson' => $lesson,
		];
    }

	/**
     * Store a newly created lesson-related resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeLessonExam(Request $request, $lessonId)
    {
	    $this->authorize('store', Exam::class);

        $lesson = Lesson::findOrFail($lessonId);

        $this->validate($request, [
			'type' => 'required|in:home,class,surprise',
			'description' => '',
			'min_mark' => 'required|numeric',
			'max_mark' => 'required|numeric',
			'document_id' => 'exists:documents,id'
		]);
		
		// ToDo: Check if document is linked to the lesson

		// ToDo: Check if the lesson has no exam yet

		$exam = new Exam();
		$exam->lesson_id = $lesson->id;
		$exam->type = $request->get('type');
		if ($request->has('description'))
			$exam->description = $request->get('description');
		if ($request->has('min_mark'))
			$exam->min_mark = $request->get('min_mark');
		if ($request->has('max_mark'))
			$exam->max_mark = $request->get('max_mark');
		if ($request->has('document_id'))
			$exam->document_id = $request->get('document_id');
		$exam->save();

	    $exam->load('document');
	    $exam->load('marks');

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
		$exam = Exam::with('lesson')
					->with('document')
					->with('marks')
					->findOrFail($id);

	    $this->authorize('show', $exam);

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
        $exam = Exam::with('lesson.documents')->findOrFail($id);

	    $this->authorize('update', $exam);

		return $exam;
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
		$exam = Exam::findOrFail($id);

	    $this->authorize('update', $exam);

		$this->validate($request, [
			'type' => 'required|in:home,class,surprise',
			'description' => '',
			'min_mark' => 'numeric',
			'max_mark' => 'numeric',
			'document_id' => 'exists:documents,id'
		]);
		
        if ($request->has('type'))
			$exam->type = $request->get('type');
		if ($request->has('description'))
			$exam->description = $request->get('description');
		if ($request->has('min_mark'))
			$exam->min_mark = $request->get('min_mark');
		if ($request->has('max_mark'))
			$exam->max_mark = $request->get('max_mark');
		$exam->document_id = $request->has('document_id') ? $request->get('document_id') : null;
		$exam->save();

		$exam->load('document');
		$exam->load('marks');

		return $exam;
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

	    $this->authorize('destroy', $exam);

	    $exam->delete();
    }
}
