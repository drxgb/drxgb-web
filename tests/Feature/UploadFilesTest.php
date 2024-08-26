<?php

namespace Tests\Feature;

use App\Utils\Upload;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadFilesTest extends TestCase
{
    /**
     * Verifica se os arquivos foram armazenados.
     */
    public function test_files_are_uploaded() : void
    {
        Storage::fake('images');

		/** @var FilesystemAdapter */
		$fs = Storage::disk('images');

		$basePath = 'product-images';
		$size = intval(date('Y'));

		for ($id = 0; $id < $size; ++$id)
		{
			$files = array_map(
				fn (mixed $name): File => UploadedFile::fake()->image(
					Upload::makePathById($basePath, $id, "$name.png")
				),
				range(0, random_int(1, 5)),
			);


			foreach ($files as $file)
			{
				$fs->put(Upload::makePathById($basePath, $id), $file);
				$fs->assertExists(Upload::makePathById($basePath, $id, $file->hashName()));
			}
		}
    }
}
