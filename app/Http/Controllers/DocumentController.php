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
        $this->authorize('store', Document::class);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $this->authorize('store', Document::class);


    }

	/**
	 * @api {post} /lessons/:lessonId/documents Store new document
	 * @apiName store
	 * @apiGroup Documents
	 *
     * @apiDescription Store a new document and link it to the specified lesson.
	 *
	 * @apiParam {String}	name			Name of the file
	 * @apiParam {String}	description		Description of the content
	 * @apiParam {File}		document		Document file
	 */
    public function storeLessonDocument(Request $request, $lessonId)
    {
	    $this->authorize('store', Document::class);

		$lesson = Lesson::findOrFail($lessonId);

        $this->validate($request, [
			'name' => 'required',
			'description' => '',
			'document' => 'required|file|mimes:pdf,jpeg,png',
		]);

		$document = new Document();
		$document->lesson_id = $lesson->id;
		$document->name = $request->get('name');
		$document->description = $request->get('description');
		$document->path = $request->file('document')->store('public/documents');
		$document->filename = pathinfo($request->file('document')->getClientOriginalName(), PATHINFO_FILENAME);
		$document->extension = pathinfo($request->file('document')->getClientOriginalName(), PATHINFO_EXTENSION);
		$document->save();

		return $document;
    }

    /**
     * @api {get} /documents/:documentId Display document
	 * @apiName show
	 * @apiGroup Documents
	 *
     * @apiDescription Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$document = Document::findOrFail($id);

	    $this->authorize('show', $document);

		$document->url = Storage::url($document->path);

        return $document;
    }

	/**
     * @api {get} /lessons/:lessonId/documents/:documentId Display document
	 * @apiName show
	 * @apiGroup Documents
	 *
     * @apiDescription Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
	    $document = Document::findOrFail($id);

	    $this->authorize('update', $document);

	    $document->url = Storage::url($document->path);

	    return $document;
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
	    $document = Document::findOrFail($id);

	    $this->authorize('update', $document);

	    $this->validate($request, [
		    'name' => '',
		    'description' => '',
	    ]);

	    if ($request->has('name'))
	        $document->name = $request->get('name');
	    if ($request->has('description'))
		    $document->description = $request->get('description');
	    $document->save();

	    return $document;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
	    $document = Document::findOrFail($id);

	    $this->authorize('destroy', $document);

	    $document->delete();
    }
}
