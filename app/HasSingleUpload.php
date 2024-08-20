<?php

namespace App;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


trait HasSingleUpload
{
	use StoreUploadedFiles;


	/**
	 * @param UploadedFile $file
	 * @param string $filename
	 * @return void
	 */
	public function saveFile(UploadedFile $file, string $filename) : void
	{
		$key = $this->getFileFieldName();

		tap($this->$key, function (?string $previous) use ($file, $filename, $key) : void
		{
			$disk = $this->getFileDisk();
			$basePath = $this->getRootFolder();
			$ext = $this->getUploadedFileExtension($file);

			$this->store($file, $basePath, $filename, $disk);
			$this->forceFill([ $key	=> "$filename.$ext" ])->saveQuietly();

			if (!empty($previous) && $this->$key !== $previous)
			{
				$this->deleteFile($previous);
			}
		});
	}


	/**
	 * @param ?string $filename
	 * @return void
	 */
	public function deleteFile(?string $filename = null) : void
	{
		$key = $this->getFileFieldName();

		if (is_null($filename))
		{
			$filename = $this->$key;
		}
		if (is_null($filename))
		{
			return;
		}

		$path = "{$this->getRootFolder()}/$filename";
		Storage::disk($this->getFileDisk())->delete($path);
		$this->forceFill([ $key => null ])->saveQuietly();
	}


	/**
	 * @return ?string
	 */
	public function getFileName() : ?string
	{
		$key = $this->getFileFieldName();
		return $this->$key;
	}


	/**
	 * @return ?string
	 */
	public function getFullFileName() : ?string
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
		return "{$this->getRootFolder()}/_default.png";
	}
}
