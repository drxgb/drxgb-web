<?php

namespace App;


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
}
