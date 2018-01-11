<?php

namespace App\Providers;

use App\Models\AI\Difficulty;
use App\Models\Communication\Conversation;
use App\Models\Communication\Message;
use App\Models\Communication\Notification;
use App\Models\Pedagogy\Alert;
use App\Models\Pedagogy\Document;
use App\Models\Pedagogy\Evaluations\Absence;
use App\Models\Pedagogy\Evaluations\Criterion;
use App\Models\Pedagogy\Evaluations\Delay;
use App\Models\Pedagogy\Evaluations\Evaluation;
use App\Models\Pedagogy\Exams\Exam;
use App\Models\Pedagogy\Exams\Mark;
use App\Models\Pedagogy\Graph;
use App\Models\Pedagogy\Homework;
use App\Models\Pedagogy\Lesson;
use App\Models\Pedagogy\Level;
use App\Models\Pedagogy\StudentClass;
use App\Models\Pedagogy\Subject;
use App\Models\Planning\Reservation;
use App\Models\Planning\Room;
use App\Models\Processes\Process;
use App\Models\Processes\Step;
use App\Models\Users\Group;
use App\Models\Users\User;
use App\Policies\AbsencePolicy;
use App\Policies\AlertPolicy;
use App\Policies\ConversationPolicy;
use App\Policies\CriterionPolicy;
use App\Policies\DelayPolicy;
use App\Policies\DifficultyPolicy;
use App\Policies\DocumentPolicy;
use App\Policies\EvaluationPolicy;
use App\Policies\ExamPolicy;
use App\Policies\GraphPolicy;
use App\Policies\GroupPolicy;
use App\Policies\HomeworkPolicy;
use App\Policies\LessonPolicy;
use App\Policies\LevelPolicy;
use App\Policies\MarkPolicy;
use App\Policies\MessagePolicy;
use App\Policies\NotificationPolicy;
use App\Policies\ProcessPolicy;
use App\Policies\ReservationPolicy;
use App\Policies\RoomPolicy;
use App\Policies\StepPolicy;
use App\Policies\StudentClassPolicy;
use App\Policies\SubjectPolicy;
use App\Policies\UserPolicy;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
	    Absence::class => AbsencePolicy::class,
	    Alert::class => AlertPolicy::class,
	    Conversation::class => ConversationPolicy::class,
	    Criterion::class => CriterionPolicy::class,
	    Delay::class => DelayPolicy::class,
	    Difficulty::class => DifficultyPolicy::class,
	    Document::class => DocumentPolicy::class,
	    Evaluation::class => EvaluationPolicy::class,
	    Exam::class => ExamPolicy::class,
	    Graph::class => GraphPolicy::class,
	    Group::class => GroupPolicy::class,
	    Homework::class => HomeworkPolicy::class,
	    Lesson::class => LessonPolicy::class,
	    Level::class => LevelPolicy::class,
	    Mark::class => MarkPolicy::class,
	    Message::class => MessagePolicy::class,
	    Notification::class => NotificationPolicy::class,
	    Process::class => ProcessPolicy::class,
	    Reservation::class => ReservationPolicy::class,
	    Room::class => RoomPolicy::class,
	    Step::class => StepPolicy::class,
	    StudentClass::class => StudentClassPolicy::class,
	    Subject::class => SubjectPolicy::class,
	    User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
		Passport::pruneRevokedTokens();
    }
}
