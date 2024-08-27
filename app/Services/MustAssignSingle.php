<?php

namespace App\Services;


trait MustAssignSingle
{
	/**
	 * O dado atribuído.
	 *
	 * @var mixed
	 */
	protected $assignedData = null;


	/**
	 * Ação realizada na atribuição dos dados.
	 *
	 * @param mixed $data
	 * @return void
	 */
	protected abstract function onAssign(mixed $data) : void;


	/**
	 * @param mixed $data
	 * @return static
	 */
	public function assign(mixed $data) : static
	{
		$this->assignedData = $data;
		return $this;
	}


	/**
	 * Aplica a atribuição de dados.
	 *
	 * @return void
	 */
	protected function applyAssignment() : void
	{
		if (! is_null($this->assignedData))
		{
			$this->onAssign($this->assignedData);
		}
	}
}
