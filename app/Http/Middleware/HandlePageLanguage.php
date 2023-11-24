<?php

namespace App\Http\Middleware;

use Inertia\Inertia;
use Inertia\Middleware;
use App\Models\Language;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * Responsável por manipular a requisição recebendo o idioma do usuário
 * @author Dr.XGB <https://github.com/drxgb>
 * @version 1.0.0
 */
class HandlePageLanguage extends Middleware
{
	/**
	 * @param Request $request
	 * @return array<string, mixed>
	 */
	public function share(Request $request): array
	{
		/** @var Collection */
		$languages = Language::all([ 'id', 'name', 'locale', 'country_flag' ]);

		return [
			...parent::share($request),
			'languages'	=> $languages,
			'language'	=> $this->getUserLanguage($request),
		];
	}


	/**
	 * Recebe o idioma da página
	 * @param Request $request
	 * @return Language
	 */
	protected function getUserLanguage(Request $request): Language
	{
		// TODO: Verificar se sessão está autenticada por um usuário

		/** @var int */
		$id = intval($request->cookie('xgb_language_id') ?? 1);
		return Language::find($id);
	}
}
