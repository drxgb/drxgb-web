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


	/**
	 * Filtra os dados deixando somente a chave que interessa.
	 *
	 * @param array $data
	 * @param string $key
	 * @return array
	 */
	protected function filter(array $data, string $key = 'id') : array
	{
		return array_map(fn (array $item) : int => $item[$key], $data);
	}
}
