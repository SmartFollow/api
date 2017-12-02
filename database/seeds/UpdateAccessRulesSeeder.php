<?php

use Illuminate\Database\Seeder;

class UpdateAccessRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $routes = [
		    'conversations.index',
		    'conversations.store',
		    'conversations.create',
		    'conversations.destroy',
		    'conversations.update',
		    'conversations.show',
		    'conversations.edit',
		    'documents.index',
		    'documents.store',
		    'documents.create',
		    'documents.destroy',
		    'documents.update',
		    'documents.show',
		    'documents.edit',
		    'evaluations.index',
		    'evaluations.store',
		    'evaluations.create',
		    'absences.index',
		    'absences.store',
		    'absences.create',
		    'absences.show',
		    'absences.update',
		    'absences.destroy',
		    'absences.edit',
		    'criteria.show',
		    'criteria.store',
		    'criteria.index',
		    'criteria.create',
		    'criteria.update',
		    'criteria.edit',
		    'criteria.destroy',
		    'delays.store',
		    'delays.destroy',
		    'evaluations.show',
		    'evaluations.destroy',
		    'evaluations.update',
		    'evaluations.edit',
		    'exams.index',
		    'exams.store',
		    'exams.create',
		    'marks.index',
		    'marks.self.index',
		    'marks.store',
		    'marks.create',
		    'marks.update',
		    'marks.destroy',
		    'marks.show',
		    'marks.edit',
		    'exams.show',
		    'exams.destroy',
		    'exams.update',
		    'exams.edit',
		    'graphs.index',
		    'graphs.store',
		    'graphs.create',
		    'graphs.destroy',
		    'graphs.update',
		    'graphs.show',
		    'graphs.edit',
		    'groups.index',
		    'groups.create',
		    'groups.store',
		    'groups.update',
		    'groups.show',
		    'groups.destroy',
		    'groups.edit',
		    'groups.show.access-rules',
		    'lessons.index',
		    'lessons.self.index',
		    'lessons.store',
		    'lessons.create',
		    'lessons.history',
		    'lessons.documents.store',
		    'lessons.documents.show',
		    'lessons.evaluations.index',
		    'lessons.evaluations.create',
		    'lessons.exams.store',
		    'lessons.exams.show',
		    'lessons.exams.create',
		    'homeworks.index',
		    'homeworks.store',
		    'homeworks.create',
		    'homeworks.destroy',
		    'homeworks.update',
		    'homeworks.show',
		    'homeworks.edit',
		    'lessons.destroy',
		    'lessons.show',
		    'lessons.update',
		    'lessons.edit',
		    'levels.index',
		    'levels.store',
		    'levels.create',
		    'levels.student-classes.index',
		    'levels.student-classes.store',
		    'levels.subjects.index',
		    'levels.update',
		    'levels.show',
		    'levels.destroy',
		    'levels.edit',
		    'messages.store',
		    'notifications.store',
		    'notifications.index',
		    'notifications.self.index',
		    'notifications.create',
		    'notifications.mark-as-read',
		    'notifications.destroy',
		    'notifications.update',
		    'notifications.show',
		    'notifications.edit',
		    'processes.store',
		    'processes.index',
		    'processes.create',
		    'processes.destroy',
		    'processes.update',
		    'processes.show',
		    'processes.edit',
		    'reservations.index',
		    'reservations.store',
		    'reservations.create',
		    'reservations.show',
		    'reservations.update',
		    'reservations.destroy',
		    'reservations.edit',
		    'rooms.store',
		    'rooms.index',
		    'rooms.create',
		    'rooms.destroy',
		    'rooms.update',
		    'rooms.show',
		    'rooms.edit',
		    'steps.index',
		    'steps.store',
		    'steps.create',
		    'steps.show',
		    'steps.destroy',
		    'steps.update',
		    'steps.edit',
		    'student-classes.store',
		    'student-classes.index',
		    'student-classes.create',
		    'student-classes.students.update',
		    'student-classes.students.index',
		    'student-classes.subjects.index',
		    'student-classes.subjects.update',
		    'student-classes.show',
		    'student-classes.destroy',
		    'student-classes.update',
		    'student-classes.edit',
		    'subjects.index',
		    'subjects.store',
		    'subjects.create',
		    'subjects.student-classes.index',
		    'subjects.update',
		    'subjects.destroy',
		    'subjects.show',
		    'subjects.edit',
		    'users.index',
		    'users.store',
		    'users.change-password',
		    'users.profile',
		    'users.profile.access-rules',
		    'users.profile.homeworks',
		    'users.destroy',
		    'users.show',
		    'users.update',
		    'users.edit',
		    'difficulties.index',
		    'difficulties.self.index',
		    'ai.index',
		    'alerts.index',
		    'alerts.self.index',
		    'criteria.summary.received',
		    'criteria.summary.given',
		    'homeworks.self.index',
	    ];

	    foreach ($routes as $route)
	    {
	    	\App\Models\Users\AccessRule::firstOrCreate([
	    		'name' => $route,
			    'route' => $route,
		    ]);
	    }
    }
}
