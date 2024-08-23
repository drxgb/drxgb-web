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
		return $this;
	}


	/**
	 * @return static
	 */
	public function disassociate() : static
	{
		$this->associatedData = null;
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
		else
		{
			$this->onDisassociate();
		}
	}
}
