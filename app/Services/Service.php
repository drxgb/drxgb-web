<?php

namespace App\Services;


abstract class Service
{
	public function __construct()
	{
		$this->setup();
	}


	/**
	 * Alimenta os dados do serviço.
	 *
	 * @param array $attributes
	 * @return static
	 */
	public function fill(array $attributes) : static
	{
		return $this;
	}


	/**
	 * Prepara a inicialização do serviço.
	 *
	 * @return void
	 */
	protected function setup() : void
	{
		// ...
	}
}
