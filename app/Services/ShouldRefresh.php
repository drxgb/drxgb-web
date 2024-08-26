<?php

namespace App\Services;


trait ShouldRefresh
{
	/**
	 * Sinaliza se os dados devem ser atualizados.
	 *
	 * @var boolean
	 */
	protected $refresh = false;


	public function shouldRefresh(bool $refresh = true) : static
	{
		$this->refresh = $refresh;
		return $this;
	}
}
