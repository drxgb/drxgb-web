<?php

namespace App\Contracts;


/**
 * Contrato para definir que as classes devem ser acopláveis.
 *
 * @author Dr.XGB <https://drxgb.com>
 * @version 1.0.0
 */
interface Attachable
{
	/**
	 * Acoplar dados a uma instância.
	 *
	 * @param mixed $data
	 * @return mixed
	 */
	function attach(mixed $data) : mixed;
}
