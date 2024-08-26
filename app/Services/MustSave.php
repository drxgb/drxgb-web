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
	 * @return mixed
	 */
	public function save(bool $newTransaction = true) : mixed
	{
		if ($newTransaction)
		{
			DB::beginTransaction();
		}

		$result = $this->onSave();

		if ($newTransaction)
		{
			DB::commit();
		}

		return $result;
	}
}
