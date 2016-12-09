<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pedagogy\Lesson;
use App\Models\Planning\Reservation;

use DateTime;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lessons = Lesson::get();

		return $lessons;
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
		$days = [
			'SUNDAY' => 0,
			'MONDAY' => 1,
			'TUESDAY' => 2,
			'WEDNESDAY' => 3,
			'THIRSDAY' => 4,
			'FRIDAY' => 5,
			'SATURDAY' => 6,
		];

        $this->validate($request, [
			'subject_id' => 'required|exists:subjects,id',
			'reservation_id' => 'required|exists:reservations,id',
			'student_class_id' => 'required|exists:student_classes,id',
		]);

		$reservation = Reservation::findOrFail($request->get('reservation_id'));

		$recurrency_end = new DateTime($reservation->date_end);

		$nextLessonStart = new DateTime($reservation->date_start);
		if ($nextLessonStart->format('w') != $days[$reservation->day])
			$nextLessonStart->modify('next ' . $reservation->day);

		$lessons = [];
		while ($nextLessonStart <= $recurrency_end)
		{
			$nextLessonStart->modify($reservation->time_start);
			$nextLessonEnd = $nextLessonStart;
			$nextLessonEnd->modify($reservation->time_end);

			$lesson = new Lesson();
			$lesson->subject_id = $request->get('subject_id');
			$lesson->reservation_id = $request->get('reservation_id');
			$lesson->student_class_id = $request->get('student_class_id');
			$lesson->start = $nextLessonStart->format('Y-m-d H:i:s');
			$lesson->end = $nextLessonEnd->format('Y-m-d H:i:s');
			$lesson->description = $request->get('description');
			$lesson->save();

			$lessons[] = $lesson;

			$nextLessonStart->modify('next ' . $reservation->day);
		}

		return $lessons;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lesson = Lesson::findOrFail($id);

		return $lesson;
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
