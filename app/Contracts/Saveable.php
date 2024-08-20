<?php

namespace App\Contracts;


/**
 * Contrato para definir que deve ser salvo.
 *
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
interface Saveable
{
	/**
	 * Ação de salvamento.
	 *
	 * @return mixed
	 */
	function save() : mixed;
}
