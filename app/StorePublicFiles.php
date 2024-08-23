<?php

namespace App;

use Illuminate\Http\UploadedFile;


trait StorePublicFiles
{
	/**
	 * @return string
	 */
	public function getFileDisk() : string
	{
		return isset($_ENV['VAPOR_ARTIFACT_NAME'])
			? 's3'
			: 'public';
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
		return $file->storePubliclyAs($basePath, $filename, compact('disk'));
	}
}
