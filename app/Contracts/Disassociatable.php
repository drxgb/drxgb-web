<?php

namespace App\Contracts;


/**
 * Contrato para classes que devem desassociar dados.
 *
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
interface Disassociatable
{
	/**
	 * Desassocias os dados.
	 *
	 * @return mixed
	 */
	function disassociate() : mixed;
}
