<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Utils\Upload;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;

class UploadFilesTest extends TestCase
{
    /**
     * Verifica se os arquivos foram armazenados.
     */
    public function test_files_are_uploaded(): void
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
					Upload::makePath($basePath, $id, "$name.png")
				),
				range(0, random_int(1, 5)),
			);


			foreach ($files as $file)
			{
				/** @var File $file */
				$fs->put(Upload::makePath($basePath, $id), $file);
				$fs->assertExists(Upload::makePath($basePath, $id, $file->hashName()));
			}
		}
    }
}
