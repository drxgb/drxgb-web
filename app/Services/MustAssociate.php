<?php

namespace App\Services;


trait MustAssociate
{
	/**
	 * Dado a ser associado.
	 *
	 * @var mixed
	 */
	protected $associatedData;


	/**
	 * Sinaliza se o dado deve ser desassociado.
	 *
	 * @var boolean
	 */
	protected $mustDisassociate = false;


	/**
	 * Ação realizada na associação dos dados.
	 *
	 * @param mixed $data
	 * @return void
	 */
	protected abstract function onAssociate(mixed $data) : void;


	/**
	 * Ação realizada na desassociação dos dados.
	 *
	 * @return void
	 */
	protected abstract function onDisassociate() : void;


	/**
	 * @param mixed $data
	 * @return static
	 */
	public function associate(mixed $data) : static
	{
		$this->associatedData = $data;
		$this->mustDisassociate = false;

		return $this;
	}


	/**
	 * @return static
	 */
	public function disassociate() : static
	{
		$this->associatedData = null;
		$this->mustDisassociate = true;

		return $this;
	}


	/**
	 * Aplica a associação, se houver.
	 *
	 * @return void
	 */
	protected function applyAssociation() : void
	{
		if (! empty($this->associatedData))
		{
			$this->onAssociate($this->associatedData);
		}
		if ($this->mustDisassociate)
		{
			$this->onDisassociate();
		}
	}
}
