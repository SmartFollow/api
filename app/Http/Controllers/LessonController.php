<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pedagogy\Level;
use App\Models\Pedagogy\Lesson;
use App\Models\Pedagogy\Subject;
use App\Models\Planning\Reservation;
use App\Models\Users\User;
use Illuminate\Support\Facades\Auth;

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
	    $lessons = Lesson::where('student_class_id', Auth::user()->class_id)
					    ->orWhereHas('subject', function ($q) {
						    $q->where('teacher_id', Auth::id());
					    })
					    ->get();

        $lessons->load('subject');
        $lessons->load('studentClass');
        $lessons->load('reservation.room');
        $lessons->load('homeworks');
        $lessons->load('evaluations.criteria');

		return $lessons;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $available_reservations = Reservation::whereDoesntHave('lessons')->get();

		$levels = Level::with('subjects.studentClasses')->get();

		return [
			'available_reservations' => $available_reservations,
			'levels' => $levels,
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

		// Validate that the studentClass has the subject
		$classSubjectMatch = Subject::whereHas('studentClasses', function($q) use($request) {
			$q->where('student_classes.id', $request->get('student_class_id'));
		})->where('id', $request->get('subject_id'))->count() > 0;
		if (!$classSubjectMatch)
		{
			return [
				"error" => trans('lessons.student_class_doesnt_have_subject'),
			];
		}

		// Validate that the reservation is available and not already used
		$reservationIsAvailable = Lesson::where('reservation_id', $request->get('reservation_id'))->count() == 0;
		if (!$reservationIsAvailable)
			{
			return [
				"error" => trans('reservations.reservation_not_available'),
			];
		}

		$reservation = Reservation::findOrFail($request->get('reservation_id'));

		$recurrency_end = new DateTime($reservation->date_end);
		$nextLessonStart = new DateTime($reservation->date_start);
		if ($nextLessonStart->format('w') != $days[$reservation->day])
			$nextLessonStart->modify('next ' . $reservation->day);

		$reservationStart = [
			'h' => intval(date('H', strtotime($reservation->time_start))),
			'm' => intval(date('i', strtotime($reservation->time_start))),
			's' => intval(date('s', strtotime($reservation->time_start))),
		];

	    $reservationEnd = [
		    'h' => intval(date('H', strtotime($reservation->time_end))),
		    'm' => intval(date('i', strtotime($reservation->time_end))),
		    's' => intval(date('s', strtotime($reservation->time_end))),
	    ];

		$lessons = [];
		while ($nextLessonStart <= $recurrency_end)
		{
			$nextLessonStart->setTime($reservationStart['h'], $reservationStart['m'], $reservationStart['s']);
			$nextLessonEnd = clone $nextLessonStart;
			$nextLessonEnd->setTime($reservationEnd['h'], $reservationEnd['m'], $reservationEnd['s']);

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
        $lesson = Lesson::with('reservation.room')
				->with('subject.teacher')
				->with('homeworks')
                ->with('evaluations.criteria')
                ->with('evaluations.student')
				->with('documents')
				->with('exam')
				->with('studentClass.students')
				->findOrFail($id);

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
        $lesson = Lesson::findOrFail($id);

		return $lesson;
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
        $lesson = Lesson::findOrFail($id);
		
		$this->validate($request, [
			'description' => '',
		]);
		
		$lesson->description = $request->get('description');
		$lesson->save();

		return $lesson;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lesson = Lesson::findOrFail($id);

		$lesson->delete();
    }

    /**
     * Display passed lesson.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function history(Request $request)
    {
    	$lessons = Lesson::where('student_class_id', Auth::user()->class_id)
	                     ->orWhereHas('subject', function ($q) {
		                     $q->where('teacher_id', Auth::id());
	                     })
		                 ->where('end', '<=', new DateTime())
		                 ->get();

    	return $lessons;
    }
}
