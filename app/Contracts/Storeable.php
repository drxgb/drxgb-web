<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;

/**
 * Contrato para os modelos que possuem armazenamento de arquivo.
 *
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
interface Storeable
{
	/**
	 * Recebe o disco onde o arquivo está armazenado.
	 *
	 * @return string
	 */
	function getFileDisk() : string;


	/**
	 * Recebe a pasta raiz do conteúdo.
	 *
	 * @return ?string
	 */
	function getRootFolder() : ?string;


	/**
	 * Recebe o nome do arquivo que representa o conteúdo.
	 *
	 * @return ?string
	 */
	function getFileName() : ?string;


	/**
	 * Recebe a extensão do arquivo.
	 *
	 * @return string
	 */
	function getFileExtension() : string;


	/**
	 * Recebe o nome padrão do arquivo.
	 *
	 * @return string
	 */
	function getDefaultFileName() : string;


	/**
	 * Recebe o nome todo do arquivo que representa o conteúdo,
	 * normalmente com raiz e nome.
	 *
	 * @return ?string
	 */
	function getFullFileName() : ?string;


	/**
	 * Recebe o nome do campo do caminho do arquivo.
	 *
	 * @return string
	 */
	function getPathFieldName() : string;


	/**
	 * Recebe o nome do campo do arquivo.
	 *
	 * @return string
	 */
	function getFileFieldName() : string;


	/**
	 * Salva o arquivo.
	 *
	 * @param UploadedFile $file
	 * @param string $filename
	 * @return void
	 */
	function saveFile(UploadedFile $file, string $filename) : void;


	/**
	 * Renomeia o arquivo.
	 *
	 * @param string|null $newName
	 * @return void
	 */
	function renameFile(?string $newName = null) : void;


	/**
	 * Remove o arquivo.
	 *
	 * @param ?string $filename
	 * @return void
	 */
	function deleteFile(?string $filename = null) : void;
}
