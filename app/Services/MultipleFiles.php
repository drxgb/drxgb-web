<?php

namespace App\Services;

use App\Contracts\Storeable;
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
	 * @param UploadedFile[] $uploadedFiles
	 * @return static
	 */
	public function setUploadedFiles(array $uploadedFiles) : static
	{
		$this->uploadedFiles = $uploadedFiles;
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
	 * @param string $filename
	 * @return void
	 */
	protected function saveFiles(Storeable $storeable, string $filename) : void
	{
		if ($this->hasUpload())
		{
			foreach ($this->uploadedFiles as $upload)
			{
				$storeable->saveFile($upload, $filename);
			}
		}
	}
}
