<?php

namespace App\Repositories;

use App\Contracts\Iconable;
use Illuminate\Http\Request;


/**
 * Funções para repositórios que cujo seu modelo possui um ícone.
 * @author Dr.XGB <https://github.com/drxgb>
 * @version 1.0.0
 */
trait HasIcon
{
	/**
	 * Atualiza o ícone se for necessário.
	 * @param Request $request
	 * @param Iconable $iconable
	 * @return void
	 */
	private function uploadIconIfNeeded(Request $request, Iconable $iconable) : void
	{
		if ($request->hasFile('icon'))
			$iconable->saveIcon($request->file('icon'));
	}


	/**
	 * Deleta o ícone se necessário.
	 * @param Request $request
	 * @param Iconable $iconable
	 * @return void
	 */
	protected function deleteIconIfNeeded(Request $request, Iconable $iconable) : void
	{
		if ($request->deleteIcon)
			$iconable->deleteIcon();
	}
}
