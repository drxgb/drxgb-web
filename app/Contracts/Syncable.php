<?php

namespace App\Contracts;


/**
 * Contrato para sincronizar dados.
 *
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
interface Syncable
{
	/**
	 * Sincroniza os dados.
	 *
	 * @param mixed $data
	 * @return mixed
	 */
	function sync(mixed $data) : mixed;
}
