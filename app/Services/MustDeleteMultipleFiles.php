<?php

namespace App\Services;

use App\Contracts\Storeable;
use App\Utils\Upload;
use Illuminate\Support\Facades\Storage;

trait MustDeleteMultipleFiles
{
	/**
	 * Deleta os arquivos do modelo.
	 *
	 * @param Storeable $storeable
	 * @return void
	 */
	public function deleteFiles(Storeable $storeable) : void
	{
		$disk = $storeable->getFileDisk();
		$fs = Storage::disk($disk);
		$root = $storeable->getRootFolder();
		$pathField = $storeable->getPathFieldName();
		$path = Upload::makePathById($root, $storeable->$pathField);

		$fs->deleteDirectory($path);
	}


	/**
	 * Retira os arquivos que não possuem mais vínculo com o modelo.
	 *
	 * @param Storeable $storeable
	 * @param array $files
	 * @return void
	 */
	protected function cleanUnusedFiles(Storeable $storeable, int $remaining) : void
	{
		$disk = $storeable->getFileDisk();
		$fs = Storage::disk($disk);
		$usedFiles = $storeable->getFullFileName();
		$unusedFiles = array_slice($usedFiles, $remaining);
		$pathField = $storeable->getPathFieldName();

		foreach ($unusedFiles as $file)
		{
			if ($fs->exists($file))
			{
				$pathinfo = pathinfo($file);
				$filename = $pathinfo['filename'];
				$extension = $pathinfo['extension'];

				$subPath = Upload::makePathById('', $storeable->$pathField);
				$name = "{$filename}.{$extension}";

				$storeable->deleteFile($name, $subPath);
			}
		}
	}
}
