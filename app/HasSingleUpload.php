<?php

namespace App;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


trait HasSingleUpload
{
	use StorePublicFiles;


	/**
	 * @param UploadedFile $file
	 * @param string $filename
	 * @return void
	 */
	public function saveFile(UploadedFile $file, string $filename) : void
	{
		$key = $this->getPathFieldName();

		tap($this->$key, function (?string $previous) use ($file, $filename, $key) : void
		{
			$basePath = $this->getRootFolder();
			$disk = $this->getFileDisk();
			$ext = $this->getFileExtension();
			$filename .= ".{$ext}";

			$this->store($file, $basePath, $filename, $disk);
			$this->forceFill([ $key	=> $filename ])->saveQuietly();

			if (!empty($previous) && $this->$key !== $previous)
			{
				$this->deleteFile($previous);
			}
		});
	}


	/**
	 * @param string|null $newName
	 * @return void
	 */
	public function renameFile(?string $newName = null) : void
	{
		$fileKey = $this->getFileFieldName();
		$filename = $this->$fileKey;
		$extension = $this->getFileExtension();
		$filename .= ".{$extension}";

		if (is_null($newName))
		{
			$root = $this->getRootFolder();
			$newName = "{$root}/{$filename}";
		}

		$pathKey = $this->getPathFieldName();
		$oldName = $this->getFullFileName();

		$fs = Storage::disk($this->getFileDisk());

		if (! is_null($this->$pathKey) && $fs->exists($oldName) && $oldName !== $newName)
		{
			$fs->move($oldName, $newName);
		}

		$this->forceFill([ $pathKey => $filename ])->saveQuietly();
	}


	/**
	 * @param ?string $filename
	 * @return void
	 */
	public function deleteFile(?string $filename = null) : void
	{
		$key = $this->getPathFieldName();

		if (is_null($filename))
		{
			$filename = $this->$key;
		}
		if (is_null($filename))
		{
			return;
		}

		$disk = $this->getFileDisk();
		$path = "{$this->getRootFolder()}/{$filename}";

		if (! pathinfo($path, PATHINFO_EXTENSION))
		{
			$ext = $this->getFileExtension();
			$path .= ".{$ext}";
		}

		Storage::disk($disk)->delete($path);

		if ($this->exists)
		{
			$this->forceFill([ $key => null ])->saveQuietly();
		}
	}


	/**
	 * @return ?string
	 */
	public function getFileName() : ?string
	{
		$key = $this->getPathFieldName();
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
		return "{$this->getRootFolder()}/_default.{$this->getFileExtension()}";
	}
}
