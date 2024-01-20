<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;

/**
 * Contrato que contém funções para modelos que possuem ícones.
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
interface Iconable
{
	/**
	 * Recebe o caminho completo do ícone.
	 * @return Attribute
	 */
	function icon() : Attribute;


	/**
	 * Salva o arquivo do ícone.
	 * @param UploadedFile $upload
	 * @return void
	 */
	function saveIcon(UploadedFile $upload) : void;


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
