<?php

namespace App\Services;


trait MustSync
{
	/**
	 * Dados sincronizados.
	 *
	 * @var array<mixed>
	 */
	protected $syncData = [];


	/**
	 * Ação de sincronização dos dados.
	 *
	 * @param mixed $data
	 * @return void
	 */
	protected abstract function onSync(mixed $data) : void;


	/**
	 * @param mixed $data
	 * @param mixed $key
	 * @return static
	 */
	public function sync(mixed $data, mixed $key = null) : static
	{
		if (is_null($data))
		{
			return $this;
		}

		$key ??= $this->defaultSyncKey();

		if (is_null($key))
		{
			$this->syncData[] = $data;
		}
		else
		{
			$this->syncData[$key] = $data;
		}

		return $this;
	}


	/**
	 * Aplica a sincronização dos dados.
	 *
	 * @return void
	 */
	protected function applySync() : void
	{
		if (! empty($this->syncData))
		{
			$this->onSync($this->syncData);
		}
	}


	/**
	 * Recebe a chave padrão da sincronização.
	 *
	 * @return mixed
	 */
	protected function defaultSyncKey() : mixed
	{
		return null;
	}
}
