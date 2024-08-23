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
	 * @param mixed $attachment
	 * @return void
	 */
	protected abstract function onAttach(mixed $attachment) : void;


	/**
	 * @param mixed $data
	 * @return static
	 */
	public function attach(mixed $data) : static
	{
		if (! is_null($data))
		{
			$this->attachments[] = $data;
		}

		return $this;
	}


	/**
	 * @param mixed $data
	 * @return static
	 */
	public function detach(mixed $data) : static
	{
		if (! is_null($data))
		{
			$this->detachments[] = $data;
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
}
