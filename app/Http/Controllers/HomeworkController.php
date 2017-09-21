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
		
		// Check if document belongs to lesson

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
        $documents = Document::where('lesson_id', $lessonId)->get();
		$homework = Homework::findOrFail($id);

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
        $this->validate($request, [
			'description' => '',
			'document_id' => 'exists:documents,id',
		]);

		$homework = Homework::findOrFail($id);
		if ($request->has('description'))
			$homework->description = $request->get('description');
		if ($request->has('document_id'))
			$homework->document_id = $request->get('document_id');
		$homework->save();

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
        $lesson = Lesson::all();
        $homework = Homework::all();
        $user = Auth::user();
        $homework->load('lesson.subject');

        if ($user->group_id == 4)
        {
            $class = $user->class_id;
            foreach ($lesson as $lessons) {

                if ($lessons->student_class_id == $class)
                { 
                   foreach ($homework as $homeworks) {
                        return $homeworks;
                   }
                }
                else
                {
                    return [
                        'error' => 'No homeworks'
                    ];
                }
            }
        }
        else
        {
            return [
                'error' => 'Homeworks unvailable'
            ];
        }
    }
}
