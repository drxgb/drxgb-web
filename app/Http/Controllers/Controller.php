<?php

namespace App\Http\Controllers;

use App\Builders\BreadcrumbBuilder;
use Closure;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

	/**
	 * Caminho das migalhas de pão da página.
	 *
	 * @property array $breadcrumbs
	 */
	protected $breadcrumbs;


	public function __construct()
	{
		$this->breadcrumbs = [];

		// Gerar as migalhas de pão
		$this->middleware(function (Request $request, Closure $next) : HttpFoundationResponse
		{
			$builder = new BreadcrumbBuilder;
			$builder->makeFromPath($request->getPathInfo());
			$this->breadcrumbs = $builder->getResult();

			return $next($request);
		});
	}


	/**
	 * Monta o caminho da página a ser renderizada pelo Inertia.
	 * @param string $path
	 * @return string
	 */
	protected function getPageFile(string $path) : string
	{
		return $this->rootFolder() . "/$path";
	}


	/**
	 * Monta a página de resposta.
	 * @param string $page
	 * @param array $params
	 * @return Response
	 */
	protected function view(string $page, array $params = []) : Response
	{
		$params['breadcrumbs'] = $this->breadcrumbs;
		return Inertia::render($this->getPageFile($page), $params);
	}


	/**
	 * Recebe o nome da pasta base da página.
	 * @return string
	 */
	protected function rootFolder() : string
	{
		return 'Public';
	}
}
