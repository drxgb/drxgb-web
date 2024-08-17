<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        Language::create([
			'name'			=> 'English (US)',
			'locale'		=> 'en',
			'country_flag'	=> 'us',
		]);
        Language::create([
			'name'			=> 'Português (BR)',
			'locale'		=> 'pt_br',
			'country_flag'	=> 'br',
		]);
    }
}
