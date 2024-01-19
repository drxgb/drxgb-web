<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Platform::create([
			'name'			=> 'Windows 32 bit',
			'short_name'	=> 'x86',
		]);

        Platform::create([
			'name'			=> 'Windows 64 bit',
			'short_name'	=> 'x64',
		]);
    }
}
