<?php

namespace App\Services;


trait MustAttach
{
	/**
	 * Fila de anexos.
	 *
	 * @var array<mixed>
	 */
	protected $attachments = [];

	/**
	 * File de desanexos.
	 *
	 * @var array<mixed>
	 */
	protected $detachments = [];


	/**
	 * Ação de anexo de dados.
	 *
	 * @param mixed $data
	 * @return void
	 */
	protected abstract function onAttach(mixed $data) : void;


	/**
	 * Ação de anexo de dados.
	 *
	 * @param mixed $data
	 * @return void
	 */
	protected abstract function onDetach(mixed $data) : void;


	/**
	 * @param mixed $data
	 * @param ?string $key
	 * @return static
	 */
	public function attach(mixed $data, ?string $key = null) : static
	{
		if (is_null($data))
		{
			return $this;
		}

		$key ??= $this->defaultAttachKey();

		if (is_null($key))
		{
			$this->attachments[] = $data;
		}
		else
		{
			$this->attachments[$key] = $data;
		}

		return $this;
	}


	/**
	 * @param mixed $data
	 * @param ?string $key
	 * @return static
	 */
	public function detach(mixed $data, ?string $key = null) : static
	{
		if (is_null($data))
		{
			return $this;
		}

		$key ??= $this->defaultAttachKey();

		if (is_null($key))
		{
			$this->detachments[] = $data;
		}
		else
		{
			$this->detachments[$key] = $data;
		}

		return $this;
	}


	/**
	 * Aplica o anexo dos dados.
	 *
	 * @return void
	 */
	protected function applyAttachments() : void
	{
		while (! empty($this->attachments))
		{
			$attachment = array_shift($this->attachments);
			$this->onAttach($attachment);
		}

		while (! empty($this->detachments))
		{
			$detachment = array_shift($this->detachments);
			$this->onDetach($detachment);
		}
	}


	/**
	 * Recebe a chave padrão para os anexos.
	 *
	 * @return string|null
	 */
	protected function defaultAttachKey() : ?string
	{
		return null;
	}
}
