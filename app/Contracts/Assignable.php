<?php

namespace App\Contracts;


/**
 * Contrato para associar informações.
 *
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
interface Assignable
{
	/**
	 * Associa os dados.
	 *
	 * @param mixed $data
	 * @return mixed
	 */
	function assign(mixed $data) : mixed;
}
