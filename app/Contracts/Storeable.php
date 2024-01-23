<?php

namespace App\Contracts;


/**
 * Contrato para os modelos que possuem armazenamento de arquivo.
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
interface Storeable
{
	/**
	 * Recebe a pasta raiz do conteúdo.
	 * @return string
	 */
	function getRootFolder() : string;


	/**
	 * Recebe o nome do arquivo que representa o conteúdo.
	 * @return string
	 */
	function getFileName() : string;
}
