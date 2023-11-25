<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    /**
     * Modifica o idioma da página
     */
    public function change(Request $request)
    {
		/** @var Language */
		$language = Language::find($request->language_id);

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
