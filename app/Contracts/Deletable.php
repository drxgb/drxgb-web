<?php

namespace App\Contracts;


/**
 * Contrato para deletar dados.
 *
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
interface Deletable
{
	/**
	 * Realiza o processo de remoção.
	 *
	 * @return boolean
	 */
	function delete() : bool;
}
