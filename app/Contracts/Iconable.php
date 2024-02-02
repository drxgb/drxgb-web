<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;

/**
 * Contrato que contém funções para modelos que possuem ícones.
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
interface Iconable extends Storeable
{
	/**
	 * Recebe o caminho completo do ícone.
	 * @return Attribute
	 */
	function icon() : Attribute;


	/**
	 * Recebe o caminho do ícone.
	 * @return string
	 */
	function iconPath() : string;


	/**
	 * O caminho do arquivo do ícone padrão.
	 * @return string
	 */
	function defaultIcon() : string;


	/**
	 * Apaga o arquivo do ícone.
	 * @return void
	 */
	function deleteIcon() : void;
}
