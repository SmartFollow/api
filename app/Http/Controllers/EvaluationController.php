<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pedagogy\Evaluations\Evaluation;
use App\Models\Pedagogy\Lesson;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lessonId)
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
    public function create($lessonId)
    {
        
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
			'student_id' => 'exists:users,id|required',
			'comment' => '',
		]);
		
		// Verify if student is enrolled in class
		
		$evaluation = new Evaluation();
		$evaluation->lesson_id = $lessonId;
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
    public function show($lessonId, $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lessonId, $id)
    {
        
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lessonId, $id)
    {
        
    }
}
