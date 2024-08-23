<?php

namespace App\Services;

use App\Contracts\Storeable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait SingleFile
{

	/**
	 * O arquivo de upload.
	 *
	 * @var UploadedFile
	 */
	protected $uploadedFile;


	/**
	 * Recebe o arquivo de upload.
	 *
	 * @return UploadedFile
	 */
	public function getUploadedFile() : UploadedFile
	{
		return $this->uploadedFile;
	}


	/**
	 * Define o arquivo de upload.
	 *
	 * @param UploadedFile|null $uploadedFile
	 * @return static
	 */
	public function setUploadedFile(?UploadedFile $uploadedFile) : static
	{
		$this->uploadedFile = $uploadedFile;
		return $this;
	}


	/**
	 * Verifica se há um arquivo disponível para upload.
	 *
	 * @return boolean
	 */
	public function hasUpload() : bool
	{
		return ! is_null($this->uploadedFile);
	}


	/**
	 * Salva o arquivo de upload.
	 *
	 * @param Storeable $storeable
	 * @param string $filename
	 * @return void
	 */
	protected function saveFile(Storeable $storeable, string $filename) : void
	{
		if ($this->hasUpload())
		{
			$storeable->saveFile($this->getUploadedFile(), $filename);
		}
	}
}
