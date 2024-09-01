<?php

namespace App\Services;

use App\Contracts\Storeable;
use App\Utils\Upload;
use Illuminate\Http\UploadedFile;


trait MultipleFiles
{
	/**
	 * Os arquivos de upload.
	 *
	 * @var array<UploadedFile>
	 */
	protected $uploadedFiles = [];


	/**
	 * Recebe os arquivos de upload.
	 *
	 * @return UploadedFile[]
	 */
	public function getUploadedFiles() : array
	{
		return $this->uploadedFiles;
	}


	/**
	 * Define o arquivo de upload.
	 *
	 * @param UploadedFile[]|null $uploadedFiles
	 * @return static
	 */
	public function setUploadedFiles(?array $uploadedFiles) : static
	{
		if (is_array($uploadedFiles))
		{
			$this->uploadedFiles = $uploadedFiles;
		}

		return $this;
	}


	/**
	 * Verifica se há um arquivo disponível para upload.
	 *
	 * @return boolean
	 */
	public function hasUpload() : bool
	{
		return ! empty($this->uploadedFiles);
	}


	/**
	 * Salva os arquivos de upload.
	 *
	 * @param Storeable $storeable
	 * @param string|null $prefix
	 * @return void
	 */
	protected function saveFiles(Storeable $storeable, ?string $prefix = null) : void
	{
		if ($this->hasUpload())
		{
			$i = 0;
			$pathField = $storeable->getPathFieldName();
			$subPath = Upload::makePathById('', $storeable->$pathField);

			foreach ($this->uploadedFiles as $upload)
			{
				$filename = is_null($prefix) ? $i : "{$prefix}{$i}";
				$storeable->saveFile($upload, $filename, $subPath);
				++$i;
			}
		}
	}
}
