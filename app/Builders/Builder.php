<?php

namespace App\Builders;


abstract class Builder
{
	/**
	 * Resultado da construção.
	 * @var mixed
	 */
	protected $result;


	public function __construct()
	{
		$this->clear();
	}


	/**
	 * Recebe o resultado da construção.
	 * @return mixed
	 */
	public function getResult() : mixed
	{
		return $this->result;
	}


	/**
	 * Limpa o resultado da construção.
	 * @return void
	 */
	public abstract function clear() : void;
}
