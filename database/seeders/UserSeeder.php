<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
			'name' 						=> 'Dr.XGB',
            'email' 					=> 'dr.xgb.rm2k@gmail.com',
            'email_verified_at' 		=> now(),
            'password' 					=> Hash::make('kinho15'), // Mudar senha na produção imediatamente
            'two_factor_secret' 		=> null,
            'two_factor_recovery_codes'	=> null,
            'remember_token' 			=> Str::random(10),
            'profile_photo_path' 		=> null,
            'current_team_id' 			=> null,
			'language_id'				=> 1,
		]);
    }
}
