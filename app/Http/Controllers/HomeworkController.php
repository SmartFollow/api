<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pedagogy\Homework;
use App\Models\Pedagogy\Document;
use App\Models\Pedagogy\Lesson;
use Auth;

class HomeworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lessonId)
    {
    	$this->authorize('index', Homework::class);

		$homeworks = Homework::where('lesson_id', $lessonId)->get();

        $homeworks->load('lesson.subject'); 

        return $homeworks;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($lessonId)
    {
	    $this->authorize('store', Homework::class);

        $documents = Document::where('lesson_id', $lessonId)->get();

		return [
			'documents' => $documents,
		];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $lessonId)
    {
	    $this->authorize('store', Homework::class);

		$lesson = Lesson::findOrFail($lessonId);

        $this->validate($request, [
			'description' => 'required',
			'document_id' => 'exists:documents,id',
		]);
		
		// Check if document belongs to lesson

		$homework = new Homework();
		$homework->description = $request->get('description');
		$homework->lesson_id = $lesson->id;
		if ($request->has('document_id'))
			$homework->document_id = $request->get('document_id');
		$homework->save();

		$homework->load('document');

		return $homework;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($lessonId, $id)
    {
        $homework = Homework::with('document')
							->with('lesson.subject')
							->findOrFail($id);

	    $this->authorize('show', $homework);

        $homework->load('lesson.subject');

		return $homework;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lessonId, $id)
    {
	    $homework = Homework::findOrFail($id);

	    $this->authorize('update', $homework);

	    $documents = Document::where('lesson_id', $lessonId)->get();

	    return [
			'documents' => $documents,
			'homework' => $homework
		];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $lessonId, $id)
    {
	    $homework = Homework::findOrFail($id);

	    $this->authorize('update', $homework);

	    $this->validate($request, [
			'description' => '',
			'document_id' => 'exists:documents,id',
		]);

	    if ($request->has('description'))
			$homework->description = $request->get('description');
		$homework->document_id = $request->has('document_id') ? $request->get('document_id') : null;
		$homework->save();

		$homework->load('document');

		return $homework;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lessonId, $id)
    {
        $homework = Homework::findOrFail($id);

        $this->authorize('destroy', $homework);

		$homework->delete();
    }

    /**
     * Display list of homeworks.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function homeworkList(Request $request)
    {
    	$lessons = Lesson::where('student_class_id', Auth::user()->student_class)
		                ->whereHas('homeworks')
		                ->with('homeworks')
		                ->get();

    	$homeworks = [];

    	foreach ($lessons as $lesson)
	    {
	    	$homeworks = array_merge($homeworks, $lesson->homeworks);
	    }

    	return $homeworks;
    }
}
