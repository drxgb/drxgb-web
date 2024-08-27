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
	public function assign(mixed $data, ?string $key = null) : static
	{
		$key ??= $this->defaultAssignKey();

		if (is_array($data) && ! is_null($key))
		{
			$this->assignedData = $data;
		}
		else
		{
			if (! is_null($key))
			{
				$this->assignedData[$key] = $data;
			}
			else
			{
				$this->assignedData[] = $data;
			}
		}

		return $this;
	}


	/**
	 * Aplica as atribuições de dados.
	 *
	 * @return void
	 */
	protected function applyAssignment() : void
	{
		if (! empty($this->assignedData))
		{
			$this->onAssign($this->assignedData);
		}
	}


	/**
	 * Recebe a chave padrão da atribuição.
	 *
	 * @return string|null
	 */
	protected function defaultAssignKey() : ?string
	{
		return null;
	}
}
