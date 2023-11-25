<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use App\Models\User;

class LanguageController extends Controller
{
    /**
     * Modifica o idioma da página
     */
    public function change(LanguageRequest $request)
    {
		/** @var array */
		$input = $request->validated();
		/** @var Language */
		$language = Language::find($input['language_id']);
		/** @var User */
		$user = auth()->user();

		if ($user)
		{
			$user->language_id = $language->id;
			$user->save();
		}

		$request->session()->put('language_id', $language->id);
		$request->session()->put('locale', $language->locale);
		return redirect()->back();
    }
}
