<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface Breadcrumb
{
	/**
	 * Cria as migalhas de pão da página
	 * @param Request $request
	 * @return array<array<string, string>>
	 */
	function makeBreadcrumbs(Request $request): array;
}
