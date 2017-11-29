<?php

use Illuminate\Database\Seeder;

use App\Models\Users\Group;
use App\Models\Users\AccessRule;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$rules = [
    		'administrators' => ["conversations.index","conversations.store","conversations.create","conversations.destroy","conversations.update","conversations.show","conversations.edit","documents.index","documents.store","documents.create","documents.destroy","documents.update","documents.show","documents.edit","evaluations.index","evaluations.store","evaluations.create","absences.index","absences.store","absences.create","absences.show","absences.update","absences.destroy","absences.edit","criteria.store","criteria.index","criteria.create","criteria.update","criteria.edit","delays.store","delays.destroy","evaluations.show","evaluations.destroy","evaluations.update","evaluations.edit","exams.index","exams.store","exams.create","marks.index","marks.store","marks.create","marks.update","marks.destroy","marks.show","marks.edit","exams.show","exams.destroy","exams.update","exams.edit","graphs.index","graphs.store","graphs.create","graphs.destroy","graphs.update","graphs.show","graphs.edit","groups.index","groups.store","groups.update","groups.show","groups.destroy","groups.edit","groups.show.access-rules","lessons.index","lessons.self.index","lessons.store","lessons.create","lessons.history","lessons.documents.store","lessons.documents.show","lessons.evaluations.index","lessons.evaluations.create","lessons.exams.store","lessons.exams.show","lessons.exams.create","homeworks.index","homeworks.store","homeworks.create","homeworks.destroy","homeworks.show","homeworks.edit","lessons.destroy","lessons.show","lessons.update","lessons.edit","levels.index","levels.store","levels.create","levels.student-classes.index","levels.student-classes.store","levels.subjects.index","levels.update","levels.show","levels.destroy","levels.edit","messages.store","notifications.store","notifications.index","notifications.create","notifications.mark-as-read","notifications.destroy","notifications.update","notifications.show","notifications.edit","processes.store","processes.index","processes.create","processes.destroy","processes.update","processes.show","processes.edit","reservations.index","reservations.store","reservations.create","reservations.show","reservations.update","reservations.destroy","reservations.edit","rooms.store","rooms.index","rooms.create","rooms.destroy","rooms.update","rooms.show","rooms.edit","steps.index","steps.store","steps.create","steps.show","steps.destroy","steps.update","steps.edit","student-classes.store","student-classes.index","student-classes.create","student-classes.students.update","student-classes.students.index","student-classes.subjects.index","student-classes.subjects.update","student-classes.show","student-classes.destroy","student-classes.update","student-classes.edit","subjects.index","subjects.store","subjects.create","subjects.student-classes.index","subjects.update","subjects.destroy","subjects.show","subjects.edit","users.index","users.store","users.change-password","users.profile","users.profile.access-rules","users.destroy","users.show","users.update","users.edit","notifications.self.index","difficulties.index","difficulties.self.index","groups.create","criteria.show","criteria.destroy","ai.index","alerts.index","criteria.summary.given"],
		    'teachers' => ["conversations.index","conversations.store","conversations.create","conversations.destroy","conversations.update","conversations.show","conversations.edit","documents.index","documents.store","documents.create","documents.destroy","documents.update","documents.show","documents.edit","evaluations.index","evaluations.store","evaluations.create","absences.store","absences.create","absences.show","absences.update","absences.destroy","absences.edit","delays.store","delays.destroy","evaluations.show","evaluations.destroy","evaluations.update","evaluations.edit","exams.index","exams.store","exams.create","marks.index","marks.store","marks.create","marks.update","marks.destroy","marks.show","marks.edit","exams.show","exams.destroy","exams.update","exams.edit","groups.index","groups.show","groups.show.access-rules","lessons.index","lessons.self.index","lessons.store","lessons.create","lessons.history","lessons.documents.store","lessons.documents.show","lessons.evaluations.index","lessons.evaluations.create","lessons.exams.store","lessons.exams.show","lessons.exams.create","homeworks.index","homeworks.store","homeworks.create","homeworks.destroy","homeworks.update","homeworks.show","homeworks.edit","lessons.destroy","lessons.show","lessons.update","lessons.edit","levels.student-classes.index","levels.subjects.index","levels.show","messages.store","notifications.mark-as-read","reservations.index","reservations.store","reservations.create","reservations.show","reservations.update","reservations.destroy","reservations.edit","rooms.index","rooms.show","student-classes.index","student-classes.students.index","student-classes.subjects.index","student-classes.show","subjects.show","users.index","users.profile","users.profile.access-rules","users.show","notifications.self.index","difficulties.self.index","alerts.index","criteria.summary.given"],
		    'employees' => ["conversations.store","conversations.create","conversations.destroy","conversations.update","conversations.show","conversations.edit","absences.index","absences.store","absences.create","absences.show","absences.update","absences.destroy","absences.edit","groups.index","groups.show","groups.show.access-rules","lessons.index","messages.store","notifications.store","notifications.index","notifications.create","notifications.mark-as-read","notifications.destroy","notifications.update","notifications.show","notifications.edit","reservations.index","reservations.store","reservations.create","reservations.show","reservations.update","reservations.destroy","reservations.edit","rooms.index","rooms.show","student-classes.index","student-classes.students.index","student-classes.subjects.index","student-classes.show","users.index","users.store","users.change-password","users.profile","users.profile.access-rules","users.destroy","users.show","users.update","users.edit","notifications.self.index"],
		    'students' => ["conversations.index","conversations.store","conversations.create","conversations.destroy","conversations.update","conversations.show","conversations.edit","documents.show","marks.show","exams.show","lessons.self.index","lessons.history","lessons.documents.show","lessons.exams.show","homeworks.show","lessons.show","messages.store","notifications.mark-as-read","users.profile","users.profile.access-rules","users.profile.homeworks","notifications.self.index","homeworks.self.index","marks.self.index","alerts.self.index","criteria.summary.received"]
	    ];



	    $administrators = Group::create([
			'name' => 'Administrateurs',
			'description' => 'Administrateurs du logiciel',
			'deletable' => false,
			'editable' => true,
		]);
		foreach ($rules['administrators'] as $rule)
	        $administrators->accessRules()->attach(AccessRule::where('route', $rule)->first());



		$teachers = Group::create([
			'name' => 'Professeurs',
			'description' => 'Professeurs de l\'école',
			'deletable' => false,
			'editable' => true,
		]);
	    foreach ($rules['teachers'] as $rule)
		    $teachers->accessRules()->attach(AccessRule::where('route', $rule)->first());



		$employees = Group::create([
			'name' => 'Employés',
			'description' => 'Employés de l\'école',
			'deletable' => true,
			'editable' => true,
		]);
	    foreach ($rules['employees'] as $rule)
		    $employees->accessRules()->attach(AccessRule::where('route', $rule)->first());



		$students = Group::create([
			'name' => 'Étudiants',
			'description' => 'Étudiants de l\'école',
			'deletable' => false,
			'editable' => true,
		]);
	    foreach ($rules['students'] as $rule)
		    $students->accessRules()->attach(AccessRule::where('route', $rule)->first());
    }
}
