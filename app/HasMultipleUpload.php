<?php

namespace App;

use App\Utils\Upload;
use Illuminate\Support\Facades\Storage;


trait HasMultipleUpload
{
	use SimpleUpload;
	use StorePublicFiles;


	/**
	 * Recebe as imagens.
	 *
	 * @return array
	 */
	public function getFiles() : array
	{
		$field = $this->getPathFieldName();
		$disk = $this->getFileDisk();
		$root = $this->getRootFolder();
		$path = Upload::makePathById($root, $this->$field);

		return Storage::disk($disk)->files($path);
	}


	/**
	 * @return mixed
	 */
	public function getFileName() : mixed
	{
		return array_map(
			function (string $path) : string
			{
				$pathinfo = pathinfo($path);
				$filename = $pathinfo['filename'];
				$extension = $pathinfo['extension'];

				return "{$filename}.{$extension}";
			},
			$this->getFiles()
		);
	}


	/**
	 * @return mixed
	 */
	public function getFullFileName() : mixed
	{
		return $this->getFiles();
	}


	/**
	 * @return string
	 */
	public function getDefaultFileName() : string
	{
		return "{$this->getRootFolder()}/_default.{$this->getFileExtension()}";
	}
}
