<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pedagogy\Exams\Exam;
use App\Models\Pedagogy\Exams\Mark;
use Illuminate\Validation\Rule;

class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($examId)
    {
        $marks = Mark::where('exam_id', $examId)->get();

		return $marks;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($examId)
    {
        $exam = Exam::with('lesson.studentClass.students')->findOrFail($examId);

		return $exam;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $examId)
    {
		$exam = Exam::findOrFail($examId);

        $this->validate($request, [
			'student_id' => [
				'required',
				'exists:users,id',
				Rule::unique('marks')->where(function ($q) use ($examId) {
					$q->where('exam_id', $examId);
				})
			],
			'mark' => 'required|numeric|min:' . $exam->min_mark . '|max:' . $exam->max_mark,
			'comment' => '',
		]);

		// Check that student participates in exam

		$mark = new Mark();
		$mark->exam_id = $examId;
		$mark->student_id = $request->get('student_id');
		$mark->mark = $request->get('mark');
		$mark->comment = $request->get('comment');
		$mark->save();

		return $mark;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $examId, $id)
    {
		$exam = Exam::findOrFail($examId);

        $this->validate($request, [
			'mark' => 'numeric|min:' . $exam->min_mark . '|max:' . $exam->max_mark,
			'comment' => '',
		]);

		$mark = Mark::findOrFail($id);
		if ($request->has('mark'))
			$mark->mark = $request->get('mark');
		if ($request->has('comment'))
			$mark->comment = $request->get('comment');
		$mark->save();

		return $mark;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($examId, $id)
    {
        $mark = Mark::findOrFail($id);

		$mark->delete();
    }
}
