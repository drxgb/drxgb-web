<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use App\Models\Language;
use App\Models\User;
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
	 * @return Language|null
	 */
	protected function getUserLanguage(Request $request): ?Language
	{
		/** @var User */
		$user = auth()->user();
		if ($user)
			return $user->language;

		/** @var string */
		$key = 'locale';
		/** @var string */
		$locale = config('app.fallback_locale');

		if ($request->session()->has($key))
			$locale = $request->session()->get($key);
		else if ($request->hasCookie($key))
			$locale = $request->cookie($key);

		return Language::where($key, $locale)->first();
	}
}
