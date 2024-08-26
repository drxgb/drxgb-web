<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

trait MustDelete
{
	/**
	 * Ação realizada durante a remoção.
	 *
	 * @return mixed
	 */
	protected abstract function onDelete() : mixed;


	/**
	 * Realiza o processo de remoção.
	 *
	 * @return mixed
	 */
	public function delete() : mixed
	{
		DB::beginTransaction();

		$result = $this->onDelete();

		DB::commit();

		return $result;
	}
}
