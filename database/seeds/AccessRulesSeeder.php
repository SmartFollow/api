<?php

use Illuminate\Database\Seeder;

class AccessRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('access_rules')->insert([
			'name' => 'users.index',
			'route' => 'users.index',
		]);
        DB::table('access_rules')->insert([
			'name' => 'users.show',
			'route' => 'users.show',
		]);
        DB::table('access_rules')->insert([
			'name' => 'users.profile',
			'route' => 'users.profile',
		]);
        DB::table('access_rules')->insert([
			'name' => 'users.create',
			'route' => 'users.create',
		]);
        DB::table('access_rules')->insert([
			'name' => 'users.update',
			'route' => 'users.update',
		]);
        DB::table('access_rules')->insert([
			'name' => 'users.destroy',
			'route' => 'users.destroy',
		]);

		DB::table('access_rules')->insert([
			'name' => 'groups.index',
			'route' => 'groups.index',
		]);
		DB::table('access_rules')->insert([
			'name' => 'groups.create',
			'route' => 'groups.create',
		]);
		DB::table('access_rules')->insert([
			'name' => 'groups.store',
			'route' => 'groups.store',
		]);
		DB::table('access_rules')->insert([
			'name' => 'groups.show',
			'route' => 'groups.show',
		]);
		DB::table('access_rules')->insert([
			'name' => 'groups.edit',
			'route' => 'groups.edit',
		]);
		DB::table('access_rules')->insert([
			'name' => 'groups.update',
			'route' => 'groups.update',
		]);
		DB::table('access_rules')->insert([
			'name' => 'groups.destroy',
			'route' => 'groups.destroy',
		]);
		DB::table('access_rules')->insert([
			'name' => 'groups.access-rules',
			'route' => 'groups.access-rules',
		]);
    }
}
