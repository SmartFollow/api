<?php

namespace App\Http\Controllers;

use App\Models\Users\AccessRule;
use App\Models\Users\Group;
use Illuminate\Http\Request;

class DataController extends Controller
{

	public function accessRules()
	{
		$rules = AccessRule::get();

		foreach ($rules as $rule)
		{
			echo "'" . $rule->route . "',<br>";
		}
	}

	public function groupAccessRules()
	{
		$groups = Group::with('accessRules')->get();

		foreach ($groups as $group)
		{
			echo "=============== " . $group->name . " ===============<br><br>";

			echo $group->accessRules->pluck('route');

			echo "<br><br><br>";
		}
	}

}
