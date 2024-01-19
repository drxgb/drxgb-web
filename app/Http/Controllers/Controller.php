<?php

namespace App\Http\Controllers;

use App\Builders\BreadcrumbBuilder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;
use Inertia\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

	protected $breadcrumbBuilder;


	public function __construct()
	{
		$this->breadcrumbBuilder = new BreadcrumbBuilder;
	}


	/**
	 * Monta o caminho da página a ser renderizada pelo Inertia.
	 * @param string $path
	 * @return string
	 */
	protected function getPageFile(string $path): string
	{
		return $this->rootFolder() . "/$path";
	}


	/**
	 * Monta a página de resposta.
	 * @param Request $request
	 * @param string $page
	 * @param array $params
	 * @return Response
	 */
	protected function view(Request $request, string $page, array $params = []) : Response
	{
		$this->breadcrumbBuilder->makeFromPath($request->getPathInfo());
		$breadcrumbs = $this->breadcrumbBuilder->getResult();

		return Inertia::render(
			$this->getPageFile($page),
			compact('breadcrumbs') + $params
		);
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
