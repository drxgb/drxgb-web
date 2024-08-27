<?php

namespace App\Services;


trait MustValidate
{
	/**
	 * Sinaliza se a validação foi feita.
	 *
	 * @var boolean
	 */
	protected $validationComplete = false;


	/**
	 * Os erros encontrado na validação.
	 *
	 * @var array
	 */
	protected $validationErrors = [];


	/**
	 * Ação realizada durante a validação.
	 *
	 * @param array $errors
	 * @return void
	 */
	protected abstract function onValidate(array &$errors) : void;


	/**
	 * Processo de validação.
	 *
	 * @param array $errors
	 * @return boolean
	 */
	public function validate(array &$errors = []) : bool
	{
		if (! $this->validationComplete)
		{
			$this->onValidate($this->validationErrors);
			$this->validationComplete = true;
		}

		$errors = $this->validationErrors;
		return empty($errors);
	}


	/**
	 * Limpa os resultados da validação.
	 *
	 * @return void
	 */
	public function resetValidation() : void
	{
		$this->validationComplete = false;
		$this->validationErrors = [];
	}
}
