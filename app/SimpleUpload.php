<?php

namespace App;

use App\Utils\Upload;
use Illuminate\Http\UploadedFile;


trait SimpleUpload
{
	/**
	 * @param UploadedFile $file
	 * @param string $filename
	 * @param ?string $subPath
	 * @return void
	 */
	public function saveFile(UploadedFile $file, string $filename, ?string $subPath = null) : void
	{
		Upload::saveFile($this, $file, $filename, $subPath);
	}


	/**
	 * @param string|null $newName
	 * @param ?string $subPath
	 * @return void
	 */
	public function renameFile(?string $newName = null, ?string $subPath = null) : void
	{
		Upload::renameFile($this, $newName, $subPath);
	}


	/**
	 * @param string|null $filename
	 * @param ?string $subPath
	 * @return void
	 */
	public function deleteFile(?string $filename = null, ?string $subPath = null) : void
	{
		Upload::deleteFile($this, $filename, $subPath);
	}
}
