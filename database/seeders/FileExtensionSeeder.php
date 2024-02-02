<?php

namespace Database\Seeders;

use App\Models\FileExtension;
use App\Models\Platform;
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
			'icon_path'	=> 'exe.png',
		]);
		FileExtension::create([
			'name'		=> 'ZIP Compressed File',
			'extension'	=> 'zip',
			'icon_path'	=> 'zip.png',
		]);
		FileExtension::create([
			'name'		=> '7z Compressed File',
			'extension'	=> '7z',
			'icon_path'	=> '7z.png',
		]);
		FileExtension::create([
			'name'		=> 'JavaScript File',
			'extension'	=> 'js',
			'icon_path'	=> 'js.png',
		]);

		$x86 = Platform::find(1);
		$x64 = Platform::find(2);

		$ids = [ 1, 2, 3, 4 ];
		$x86->fileExtensions()->attach($ids);
		$x64->fileExtensions()->attach($ids);
    }
}
