<?php

namespace App;

use Illuminate\Http\UploadedFile;

trait HasFileExtension
{
	/**
	 * Recebe o nome do campo que representa a extensão de arquivo.
	 *
	 * @return string
	 */
	public function getFileExtensionFieldName() : string
	{
		return 'extension';
	}


	/**
	 * @return string
	 */
	public function getFileExtension() : string
	{
		$key = $this->getFileExtensionFieldName();
		return $this->$key;
	}


	/**
	 * Modifica a extensão de arquivo do modelo.
	 *
	 * @param UploadedFile|null $upload
	 * @return void
	 */
	public function setFileExtension(?UploadedFile $upload) : void
	{
		if (! is_null($upload))
		{
			$extension = $upload->getClientOriginalExtension();
			$key = $this->getFileExtensionFieldName();

			$this->forceFill(compact($key));
		}
	}
}
