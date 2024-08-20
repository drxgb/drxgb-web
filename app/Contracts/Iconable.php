<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Casts\Attribute;

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
}
