<?php

namespace App\Utils;

use App\Models\Language;
use Illuminate\Database\Eloquent\Model;

/**
 * Contém funções utilitárias para os idiomas.
 * @author Dr.XGB <https://github.com/drxgb>
 * @version 1.0.0
 */
abstract class Languages
{
	/**
	 * Summary of getFromLocale
	 * @return Language|object|Model|null
	 */
	public static function getFromLocale() : mixed
	{
		$locale = app()->getLocale();
		return Language::where('locale', $locale)->first();
	}
}
