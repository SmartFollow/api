<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pedagogy\Homework;
use App\Models\Pedagogy\Document;
use App\Models\Pedagogy\Lesson;

class HomeworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lessonId)
    {
		$homeworks = Homework::where('lesson_id', $lessonId)->get();

        return $homeworks;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($lessonId)
    {
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
		$lesson = Lesson::findOrFail($lessonId);

        $this->validate($request, [
			'description' => 'required',
			'document_id' => 'exists:documents,id',
		]);

		$homework = new Homework();
		$homework->description = $request->get('description');
		$homework->lesson_id = $lesson->id;
		if ($request->has('document_id'))
			$homework->document_id = $request->get('document_id');
		$homework->save();

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
        //
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
        //
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

		$homework->delete();
    }
}
