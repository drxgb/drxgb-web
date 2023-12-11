<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


	/**
	 * Monta o caminho da página a ser renderizada pelo Inertia.
	 * @param string $path
	 * @return string
	 */
	protected function view(string $path): string
	{
		return $this->rootFolder() . "/$path";
	}


	/**
	 * Recebe o nome da pasta base da página.
	 * @return string
	 */
	protected function rootFolder(): string
	{
		return 'Public';
	}
}
