<?php

namespace App\Contracts;


/**
 * Contrato para classes que devem associar dados.
 *
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
interface Associatable
{
	/**
	 * Associa os dados.
	 *
	 * @param mixed $data
	 * @return mixed
	 */
	function associate(mixed $data) : mixed;
}
