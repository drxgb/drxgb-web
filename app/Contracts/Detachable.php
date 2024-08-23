<?php

namespace App\Contracts;


/**
 * Contrato para classes que devem remover anexos.
 *
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
interface Detachable
{
	/**
	 * Remove anexos.
	 *
	 * @param mixed $data
	 * @return mixed
	 */
	function detach(mixed $data) : mixed;
}
