<?php

namespace App\Services;

use App\Contracts\Iconable;
use Illuminate\Http\Request;


/**
 * Funções para serviçoes que cujo seu modelo possui um ícone.
 * @author Dr.XGB <https://github.com/drxgb>
 * @version 1.0.0
 */
trait HasIcon
{
	/**
	 * Atualiza o ícone se for necessário.
	 * @param Request $request
	 * @param Iconable $iconable
	 * @return bool
	 */
	private function uploadIconIfNeeded(Request $request, Iconable $iconable) : bool
	{
		if ($request->hasFile('icon'))
		{
			$iconable->saveIcon($request->file('icon'));
			return true;
		}

		return false;
	}


	/**
	 * Deleta o ícone se necessário.
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Contracts\Iconable $iconable
	 * @return bool
	 */
	protected function deleteIconIfNeeded(Request $request, Iconable $iconable) : bool
	{
		if ($request->deleteIcon)
		{
			$iconable->deleteIcon();
			return true;
		}

		return false;
	}
}
