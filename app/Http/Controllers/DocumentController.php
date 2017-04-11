<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Pedagogy\Lesson;
use App\Models\Pedagogy\Document;

class DocumentController extends Controller
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

    public function storeLessonDocument(Request $request, $lessonId)
    {
		$lesson = Lesson::findOrFail($lessonId);

        $this->validate($request, [
			'name' => 'required',
			'description' => 'required',
			'document' => 'required|file|mimes:pdf,jpeg,png',
		]);

		$document = new Document();
		$document->lesson_id = $lesson->id;
		$document->name = $request->get('name');
		$document->description = $request->get('description');
		$document->path = $request->file('document')->store('documents');
		$document->filename = pathinfo($request->file('document')->getClientOriginalName(), PATHINFO_FILENAME);
		$document->extension = pathinfo($request->file('document')->getClientOriginalName(), PATHINFO_EXTENSION);
		$document->save();

		return $document;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$document = Document::findOrFail($id);
		
		$document->url = Storage::url($document->path);
		
        return $document;
    }
	
	public function showLessonDocument($lessonId, $id)
	{
		return $this->show($id);
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
        //
    }
}
