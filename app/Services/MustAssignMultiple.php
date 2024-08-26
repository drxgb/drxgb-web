<?php

namespace App\Services;


trait MustAssignMultiple
{
	/**
	 * Os dados atribuídos.
	 *
	 * @var array<mixed>
	 */
	protected $assignedData;


	/**
	 * Ação realizada na atribuição dos dados.
	 *
	 * @param array $data
	 * @return void
	 */
	protected abstract function onAssign(array $data) : void;


	/**
	 * @param mixed $data
	 * @return static
	 */
	public function assign(mixed $data) : static
	{
		if (is_array($data))
		{
			$this->assignedData = $data;
		}
		else
		{
			$this->assignedData[] = $data;
		}

		return $this;
	}


	/**
	 * Aplica as atribuições de dados.
	 *
	 * @return void
	 */
	public function applyAssignment() : void
	{
		if (! empty($this->assignedData))
		{
			$this->onAssign($this->assignedData);
		}
	}
}
