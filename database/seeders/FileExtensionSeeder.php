<?php

namespace Database\Seeders;

use App\Models\FileExtension;
use App\Models\Platform;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FileExtensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FileExtension::create([
			'name'		=> 'Windows Executable File',
			'extension'	=> 'exe',
		]);
		FileExtension::create([
			'name'		=> 'ZIP Compressed File',
			'extension'	=> 'zip',
		]);

		/** @var Platform */
		$x86 = Platform::find(1);
		/** @var Platform */
		$x64 = Platform::find(2);

		$x86->fileExtensions()->attach([1, 2]);
		$x64->fileExtensions()->attach([1, 2]);
    }
}
