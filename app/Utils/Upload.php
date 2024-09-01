<?php

namespace App\Utils;

use App\Contracts\Storeable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

abstract class Upload
{
	/**
	 * Monta o caminho com a estrutura padrão das subpastas de acordo com o ID.
	 *
	 * @param string $basePath
	 * @param mixed $id
	 * @param string $filename
	 * @return string
	 */
	public static function makePathById(string $basePath, ?int $id = null, ?string $filename = null) : string
	{
		if (!is_null($id))
		{
			return sprintf('%s/%d/%d/%s',
				$basePath,
				floor($id / 1000),
				$id,
				$filename
			);
		}

		return "$basePath/$filename";
	}


	/**
	 * Salva o arquivo enviado por upload.
	 *
	 * @param Storeable $storeable
	 * @param UploadedFile $file
	 * @param string $filename
	 * @param string|null $subPath
	 * @return string
	 */
	public static function saveFile(
		Storeable $storeable,
		UploadedFile $file,
		string $filename,
		?string $subPath = null
	) : string
	{
		$basePath = $storeable->getRootFolder();
		$disk = $storeable->getFileDisk();
		$ext = $storeable->getFileExtension();
		$filename .= ".{$ext}";

		if (! is_null($subPath))
		{
			$basePath .= "/$subPath";
		}

		return $file->storePubliclyAs($basePath, $filename, compact('disk'));
	}


	/**
	 * Renomeia o arquivo enviado por upload.
	 *
	 * @param Storeable $storeable
	 * @param string|null $newName
	 * @param ?string $subPath
	 * @return void
	 */
	public static function renameFile(
		Storeable $storeable,
		?string $newName = null,
		?string $subPath = null
	) : void
	{
		$fileKey = $storeable->getFileFieldName();
		$filename = $storeable->$fileKey;
		$extension = $storeable->getFileExtension();
		$filename .= ".{$extension}";

		if (is_null($newName))
		{
			$root = $storeable->getRootFolder();

			if (! is_null($subPath))
			{
				$root .= "/$subPath";
			}

			$newName = "{$root}/{$filename}";
		}

		$pathKey = $storeable->getPathFieldName();
		$oldName = $storeable->getFullFileName();

		$fs = Storage::disk($storeable->getFileDisk());

		if (! is_null($storeable->$pathKey) && $fs->exists($oldName) && $oldName !== $newName)
		{
			$fs->move($oldName, $newName);
		}
	}


	/**
	 * Deleta o arquivo enviado por upload.
	 *
	 * @param Storeable $storeable
	 * @param string|null $filename
	 * @param ?string $subPath
	 * @return void
	 */
	public static function deleteFile(
		Storeable $storeable,
		?string $filename = null,
		?string $subPath = null
	) : void
	{
		$key = $storeable->getPathFieldName();

		if (is_null($filename))
		{
			$filename = $storeable->$key;
		}
		if (is_null($filename))
		{
			return;
		}

		$disk = $storeable->getFileDisk();
		$root = $storeable->getRootFolder();

		if (! is_null($subPath))
		{
			$root .= "/$subPath";
		}

		$path = "{$root}/{$filename}";

		if (! pathinfo($path, PATHINFO_EXTENSION))
		{
			$ext = $storeable->getFileExtension();
			$path .= ".{$ext}";
		}

		Storage::disk($disk)->delete($path);
	}
}
