<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;


trait MustSave
{
	/**
	 * Ação realizada durante a gravação.
	 *
	 * @return mixed
	 */
	protected abstract function onSave() : mixed;


	/**
	 * Realiza o processo de gravação.
	 *
	 * @return mixed
	 */
	public function save() : mixed
	{
		DB::beginTransaction();

		$result = $this->onSave();

		DB::commit();

		return $result;
	}
}
