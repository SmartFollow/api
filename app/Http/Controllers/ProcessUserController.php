<?php

namespace App\Http\Controllers;

use App\Models\Processes\Step;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProcessUserController extends Controller
{
    public function store(Request $request)
    {
    	$this->validate($request, [
    		'user_id' => 'required|exists:users,id',
		    'process_id' => 'required|exists:processes,id',
		    'step_id' => 'exists:steps,id',
	    ]);

		$stepId = $request->step_id ?? null;
		if (empty($stepId))
			$stepId = Step::where('process_id', $request->process_id)->firstOrFail()->id;

		$user = User::findOrFail($request->user_id);

		$user->processes()->attach($request->process_id, ['step_id' => $stepId]);

		$user->load('processes.steps');

		return $user->processes;
    }

	public function update(Request $request)
	{
		$this->validate($request, [
			'user_id' => 'required|exists:users,id',
			'process_id' => 'required|exists:processes,id',
			'step_id' => 'required|exists:steps,id',
		]);

		$user = User::findOrFail($request->user_id);

		$user->processes()->updateExistingPivot($request->process_id, ['step_id' => $request->step_id]);

		$user->load('processes.steps');

		return $user->processes;
	}

	public function userProcesses(User $user)
	{
		$user->load('processes.steps');

		return $user->processes;
	}

	public function profileProcesses()
	{
		return $this->userProcesses(Auth::user());
	}
}
