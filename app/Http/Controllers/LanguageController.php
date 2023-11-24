<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;

class LanguageController extends Controller
{
    /**
     * Modifica o idioma da página
     */
    public function change(Request $request, int $id)
    {
		/** @var Cookie */
        $cookie = cookie('xgb_language_id', $id, 86400 * 360);
		return back()->withCookie($cookie);
    }
}
