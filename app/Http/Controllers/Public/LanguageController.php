<?php

namespace App\Http\Controllers\Public;

use App\Models\User;
use App\Models\Language;
use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;

class LanguageController extends Controller
{
    /**
     * Modifica o idioma da página.
     */
    public function change(LanguageRequest $request)
    {
		$input = $request->validated();
		$language = Language::find($input['language_id']);

		/** @var User */
		$user = auth()->user();

		if ($user)
		{
			$user->language_id = $language->id;
			$user->save();
		}

		$request->session()->put('locale', $language->locale);
		$cookie = cookie('locale', $language->locale, 60 * 24 * 360);

		return redirect()->back()->withCookie($cookie);
    }
}
