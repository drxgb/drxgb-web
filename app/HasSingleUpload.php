<?php

namespace App;

use App\Utils\Upload;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


trait HasSingleUpload
{
	use StorePublicFiles;


	/**
	 * @param UploadedFile $file
	 * @param string $filename
	 * @param ?string $subPath
	 * @return void
	 */
	public function saveFile(UploadedFile $file, string $filename, ?string $subPath = null) : void
	{
		$key = $this->getPathFieldName();

		tap($this->$key, function (?string $previous) use ($file, $filename, $subPath, $key) : void
		{
			Upload::saveFile($this, $file, $filename, $subPath);
			$this->forceFill([ $key	=> $filename ])->saveQuietly();

			if (!empty($previous) && $this->$key !== $previous)
			{
				$this->deleteFile($previous);
			}
		});
	}


	/**
	 * @param string|null $newName
	 * @param ?string $subPath
	 * @return void
	 */
	public function renameFile(?string $newName = null, ?string $subPath = null) : void
	{
		$pathKey = $this->getPathFieldName();
		$fileKey = $this->getFileFieldName();
		$filename = $this->$fileKey;

		Upload::renameFile($this, $newName, $subPath);
		$this->forceFill([ $pathKey => $filename ])->saveQuietly();
	}


	/**
	 * @param ?string $filename
	 * @param ?string $subPath
	 * @return void
	 */
	public function deleteFile(?string $filename = null, ?string $subPath = null) : void
	{
		Upload::deleteFile($this, $filename, $subPath);

		if ($this->exists)
		{
			$key = $this->getPathFieldName();
			$this->forceFill([ $key => null ])->saveQuietly();
		}
	}


	/**
	 * @return mixed
	 */
	public function getFileName() : mixed
	{
		$key = $this->getPathFieldName();
		return $this->$key;
	}


	/**
	 * @return mixed
	 */
	public function getFullFileName() : mixed
	{
		$filename = $this->getFileName();

		return ! is_null($filename)
			? "{$this->getRootFolder()}/$filename"
			: null;
	}


	/**
	 * @return string
	 */
	public function getDefaultFileName() : string
	{
		return "{$this->getRootFolder()}/_default.{$this->getFileExtension()}";
	}
}
