<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

trait MustDelete
{
	/**
	 * Ação realizada durante a remoção.
	 *
	 * @return boolean
	 */
	protected abstract function onDelete() : bool;


	/**
	 * Realiza o processo de remoção.
	 *
	 * @return boolean
	 */
	public function delete() : bool
	{
		DB::beginTransaction();

		$result = $this->onDelete();

		DB::commit();

		return $result;
	}
}
