<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Illuminate\Http\Request;
use Inertia\Middleware;

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
		return [
			...parent::share($request),
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
