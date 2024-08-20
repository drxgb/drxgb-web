<?php

namespace App;

use Illuminate\Http\UploadedFile;


trait StoreUploadedFiles
{
	/**
	 * @return string
	 */
	protected function getFileDisk() : string
	{
		if (isset($_ENV['VAPOR_ARTIFACT_NAME']))
		{
			return 's3';
		}

		return $_ENV['APP_ENV'] === 'testing'
			? config('filesystems.test_disk')
			: config('jetstream.profile_photo_disk', 'public');
	}


	/**
	 * Armazena o arquivo enviado por upload no disco.
	 *
	 * @param UploadedFile $file
	 * @param string $basePath
	 * @param string $filename
	 * @param string $disk
	 * @return string
	 */
	protected function store(
		UploadedFile $file,
		string $basePath,
		string $filename,
		string $disk = 'public'
	) : string
	{
		$extension = $this->getUploadedFileExtension($file);
		$filename .= ".$extension";

		return $file->storePubliclyAs($basePath, $filename, compact('disk'));
	}


	/**
	 * Recebe a extensão do arquivo enviado por upload.
	 *
	 * @param UploadedFile $file
	 * @return string
	 */
	protected function getUploadedFileExtension(UploadedFile $file) : string
	{
		return $file->extension();
	}
}
