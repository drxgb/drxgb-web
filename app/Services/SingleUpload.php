<?php

namespace App\Services;

use App\Contracts\Storeable;
use Illuminate\Http\UploadedFile;

trait SingleUpload
{

	/**
	 * O arquivo de upload.
	 *
	 * @var UploadedFile
	 */
	protected $uploadedFile;

	/**
	 * Sinaliza que o arquivo precisa ser deletado.
	 *
	 * @var boolean
	 */
	protected $deleteFile = false;


	/**
	 * Salva o arquivo de upload.
	 *
	 * @param Storeable $storeable
	 * @param string $filename
	 * @return void
	 */
	protected function saveUpload(Storeable $storeable, string $filename) : void
	{
		if ($this->hasUpload())
		{
			$storeable->saveFile($this->getUploadedFile(), $filename);
		}
	}


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
	 * Determina se o arquivo deve ser deletado.
	 *
	 * @param boolean $delete
	 * @return static
	 */
	public function mustDelete(bool $delete = true) : static
	{
		$this->deleteFile = $delete;
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
}
