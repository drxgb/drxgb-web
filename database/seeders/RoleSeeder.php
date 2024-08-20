<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        Role::create([
			'name'		=> 'Administrator',
			'priority'	=> 9999,
			'is_admin'	=> true,
		]);
        Role::create([
			'name'		=> 'Member',
			'priority'	=> 100,
			'is_admin'	=> false,
		]);
    }
}
